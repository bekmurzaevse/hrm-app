<?php

namespace Tests\Feature\Task;

use App\Enums\Task\TaskHistoryType;
use App\Enums\Task\TaskPriorityEnum;
use App\Enums\Task\TaskStatusEnum;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskTest extends TestCase
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

    public function test_task_can_get_all(): void
    {
        $response = $this->getJson("api/v1/tasks");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    public function test_task_can_show(): void
    {
        $taskId = Task::inRandomOrder()->first()->id;

        $response = $this->getJson('/api/v1/tasks/' . $taskId);

        $response
            ->assertStatus(200);
    }

    public function test_task_can_created_successfully(): void
    {

        $data = [
            'title' => 'Test Task',
            'description' => 'Test description',
            'deadline' => now()->format('Y-m-d H:i'),
            'status' => TaskStatusEnum::OPEN->value,
            'priority' => TaskPriorityEnum::MEDIUM->value,
            'comment' => 'Initial comment',
        ];

        $response = $this->postJson('/api/v1/tasks/create', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Successfully created',
            ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'description' => 'Test description',
            'created_by' => auth()->user()->id,
        ]);
    }

    public function test_task_can_updates()
    {
        $taskId = Task::inRandomOrder()->first()->id;

        $payload = [
            'title' => 'New Title',
            'description' => 'Updated description',
            'deadline' => '2025-09-16 09:24',
            'status' => TaskStatusEnum::IN_PROGRESS->value,
            'priority' => 'high',
        ];

        $response = $this->putJson("/api/v1/tasks/update/{$taskId}", $payload);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'title',
                    'description',
                    'deadline',
                    'created_by' => [
                        'id',
                        'name',
                    ],
                    'status',
                    'priority',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $taskId,
            'title' => 'New Title',
            'description' => 'Updated description',
            'status' => 'in_progress',
            'priority' => 'high',
        ]);

        $this->assertDatabaseHas('task_histories', [
            'task_id' => $taskId,
            'changed_by' => auth()->user()->id, 
            'type' => TaskHistoryType::TaskUpdated,
        ]);
    }

    public function test_task_user_can_complete_task(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::OPEN]);

        TaskUser::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'status' => TaskStatusEnum::IN_PROGRESS->value,
        ]);

        $payload = [
            'task_id' => $task->id,
            'comment' => 'Task bolindi',
        ];

        $response = $this->postJson('/api/v1/tasks/complete', $payload);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Задача отмечена как выполненная',
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => TaskStatusEnum::COMPLETED,
        ]);    

        $this->assertDatabaseHas('task_users', [
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'status' => TaskStatusEnum::COMPLETED,
        ]);

        $this->assertDatabaseHas('task_histories', [
            'task_id' => $task->id,
            'changed_by' => auth()->id(),
            'type' => TaskHistoryType::TaskCompleted,
            'comment' => 'Задача выполнена. Комментарий: Task bolindi',
        ]);
    }
}