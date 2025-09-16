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
        $task = Task::inRandomOrder()->first();

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
    }

    public function test_executor_can_updated()
    {
        $task = Task::inRandomOrder()->first();

        $oldExecutor = User::find(1);
        TaskUser::create([
            'task_id' => $task->id,
            'user_id' => $oldExecutor->id,
            'status' => 'in_progress',
        ]);

        $newExecutor = User::find(2);

        $payload = [
            'old_user_id' => $oldExecutor->id,
            'new_user_id' => $newExecutor->id,
            'comment' => 'Test comment',
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
    }

    // public function test_executor_can_be_removed(): void
    // {
    //     $task = Task::factory()->create([
    //         'created_by' => 1,
    //         'comment' => 'Test task',
    //     ]);

    //     $executor = User::factory()->create();

    //     TaskUser::create([
    //         'task_id' => $task->id,
    //         'user_id' => $executor->id,
    //         'status' => 'in_progress',
    //     ]);

    //     $payload = [
    //         'user_id' => $executor->id,
    //         'comment' => 'Removed for test',
    //     ];

    //     $response = $this->withHeaders([
    //         'Content-Type' => 'application/json',
    //     ])->deleteJson("/api/v1/tasks/{$task->id}/remove-executor", $payload);

    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'status' => 200,
    //             'message' => 'Исполнитель успешно удален',
    //         ]);

    //     $this->assertDatabaseMissing('task_users', [
    //         'task_id' => $task->id,
    //         'user_id' => $executor->id,
    //     ]);
    // }

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
            'status' => 'in_progress',
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

        // $this->assertDatabaseMissing('task_users', [
        //     'task_id' => $task->id,
        //     'user_id' => $executor->id,
        // ]);

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
        $task = Task::inRandomOrder()->first();

        $payload = [
            'task_id' => $task->id,
            'comment' => 'Rejected for testing',
        ];

        $response = $this->postJson("/api/v1/tasks/{$task->id}/reject", $payload);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Задача отклонена',
            ]);

        // $this->assertDatabaseHas('tasks', [
        //     'id'     => $task->id,
        //     'status' => 'rejected',
        // ]);

        $this->assertDatabaseHas('task_histories', [
            'task_id' => $task->id,
            'type' => TaskHistoryType::TaskRejected,
            'comment' => 'Rejected for testing',
        ]);
    }

    public function test_task_can_be_transferred(): void
    {
        $task = Task::inRandomOrder()->first();
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

        $this->assertDatabaseHas('task_histories', [
            'task_id' => $task->id,
            'type' => TaskHistoryType::TaskSent,
        ]);
    }


}