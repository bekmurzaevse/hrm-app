<?php

namespace Tests\Feature\Task;

use App\Enums\Task\TaskHistoryType;
use App\Enums\Task\TaskStatusEnum;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();

        $user = User::find(1);
        Sanctum::actingAs($user, ['access-token']);
    }

    public function test_executor_can_be_added(): void
    {
        $task = Task::where('created_by', auth()->id())->first();

        $executor = User::whereDoesntHave('assignedTasks', function ($q) use ($task) {
            $q->where('task_id', $task->id);
        })->firstOrFail();

        $payload = [
            'user_id' => $executor->id,
            'comment' => 'open',
        ];

        $response = $this->postJson("/api/v1/tasks/{$task->id}/add-executor", $payload);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Исполнитель успешно добавлен',
            ]);

        $this->assertDatabaseHas('task_users', [
            'task_id' => $task->id,
            'user_id' => $executor->id,
        ]);

        $id = $executor->id;
        $comment = "Добавлен исполнитель (ID: " . $id . "). Комментарий: open";

        $this->assertDatabaseHas('task_histories', [
            'task_id' => $task->id,
            'changed_by' => auth()->id(),
            'type' => TaskHistoryType::ExecutorAdded,
            'comment' => $comment
        ]);

    }

    public function test_executor_can_updated()
    {
        $creator = User::find(1);
        $oldExecutor = User::find(2);
        $newExecutor = User::find(3);

        $task = Task::factory()->create([
            'created_by' => $creator->id,
        ]);

        TaskUser::create([
            'task_id' => $task->id,
            'user_id' => $oldExecutor->id,
            'status' => TaskStatusEnum::OPEN->value,
        ]);

        $payload = [
            'old_user_id' => $oldExecutor->id,
            'new_user_id' => $newExecutor->id,
            'comment' => 'Test comment update',
        ];

        $response = $this->putJson("/api/v1/tasks/{$task->id}/update-executor", $payload);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Исполнитель успешно обновлен',
            ]);

        $this->assertDatabaseHas('task_users', [
            'task_id' => $task->id,
            'user_id' => $newExecutor->id,
        ]);

        $comment = "Исполнитель изменен: {$oldExecutor->id} → {$newExecutor->id}. Комментарий: Test comment update";

        $this->assertDatabaseHas('task_histories', [
            'task_id' => $task->id,
            'changed_by' => $creator->id,
            'type' => TaskHistoryType::ExecutorChanged,
            'comment' => $comment
        ]);
    }

    public function test_executor_can_be_removed(): void
    {
        $executor = User::factory()->create();

        $task = Task::factory()->create([
            'created_by' => 1,
            'comment' => 'Test task',
        ]);

        TaskUser::create([
            'task_id' => $task->id,
            'user_id' => $executor->id,
            'status' => TaskStatusEnum::IN_PROGRESS->value,
        ]);

        $payload = [
            'task_id' => $task->id,
            'user_id' => $executor->id,
            'comment' => 'Removed for test',
        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->deleteJson('/api/v1/tasks/' . $task->id . '/remove-executor', $payload);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Исполнитель успешно удален',
            ]);

        $this->assertSoftDeleted('task_users', [
            'task_id' => $task->id,
            'user_id' => $executor->id,
        ]);

        $this->assertDatabaseHas('task_histories', [
            'task_id' => $task->id,
            'changed_by' => auth()->id(),
            'type' => TaskHistoryType::ExecutorRemoved,
            'comment' => "Исполнитель удален (ID: {$executor->id}). Комментарий: Removed for test",
        ]);
    }


    public function test_task_history_can_be_retrieved(): void
    {
        $task = Task::inRandomOrder()->first();

        $response = $this->getJson("/api/v1/tasks/{$task->id}/history");

        $response->assertStatus(200);

    }

    public function test_task_can_be_rejected(): void
    {
        $user = User::find(1);
        $task = Task::factory()->create([
            'created_by' => $user->id,
        ]);

        TaskUser::create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'accepted_at' => now(),
            'status' => TaskStatusEnum::IN_PROGRESS->value,
        ]);

        $payload = [
            'task_id' => $task->id,
            'comment' => 'Rejected for testing',
        ];

        $response = $this->putJson("/api/v1/tasks/{$task->id}/reject", $payload);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Задача отклонена',
            ]);

        $this->assertDatabaseHas('task_users', [
            'task_id' => $task->id,
            'user_id' => $user->id,
            'status' => TaskStatusEnum::REJECTED->value,
        ]);

        $this->assertDatabaseHas('task_histories', [
            'task_id' => $task->id,
            'type' => TaskHistoryType::TaskRejected->value,
            'changed_by' => $user->id,
            'comment' => 'Rejected for testing',
        ]);
    }

    public function test_task_can_be_transferred(): void
    {
        $task = Task::where('created_by', auth()->id())->first();
        $newExecutor = User::where('id', '!=', $task->executor_id)->firstOrFail();

        $payload = [
            'user_id' => $newExecutor->id,
            'comment' => 'Transfer test comment',
        ];

        $response = $this->postJson("/api/v1/tasks/{$task->id}/transfer", $payload);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Задача успешно отправлена',
            ]);

        $comment = "Задача отправлена пользователю (ID: {$newExecutor->id})"
            . ". Комментарий: Transfer test comment";

        $this->assertDatabaseHas('task_histories', [
            'task_id' => $task->id,
            'changed_by' => auth()->id(),
            'type' => TaskHistoryType::TaskSent,
            'comment' => $comment
        ]);
    }
}