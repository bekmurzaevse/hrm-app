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

        $response->assertStatus(200);

        $this->assertIsArray($response->json('data')); // 👈 bu xatolikni oldini oladi

        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'items' => [
                    [
                        'id',
                        'title',
                        'description',
                        'status',
                        'executors',
                        'created_by' => [
                            'id',
                            'name',
                        ],
                        'deadline',
                        'deadline_human',
                        'color',
                        'priority',
                        'created_at',
                        'updated_at',
                    ]
                ],
                'pagination' => [
                    'current_page',
                    'per_page',
                    'last_page',
                    'total',
                ],
            ],
        ]);
    }


    public function test_task_can_show(): void
    {
        $user = User::find(1);
        $task = Task::factory()->create([
            'created_by' => $user->id,
        ]);

        TaskUser::create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'accepted_at' => now(),
            'status' => 'open',
        ]);

        $response = $this->getJson('/api/v1/tasks/' . $task->id);

        $response->assertStatus(200);

        $this->assertIsArray($response->json('data'));

        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'title',
                'description',
                'status',
                'executors',
                'created_by' => [
                    'id',
                    'name',
                ],
                'deadline',
                'deadline_human',
                'color',
                'priority',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_task_can_created_successfully(): void
    {
        $user = User::find(1);

        $data = [
            'title' => 'Test Task',
            'description' => 'Test description',
            'deadline' => now()->format('Y-m-d'),
            'created_by' => $user->id,
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

        $taskId = Task::where('title', 'Test Task')->firstOrFail()->id;    

        $this->assertDatabaseHas('tasks', [
            'id' => $taskId,
            'title' => 'Test Task',
            'description' => 'Test description',
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('task_histories', [
            'task_id' => $taskId,
            'changed_by' => $user->id,
            'type' => TaskHistoryType::TaskCreated,
        ]);
    }

    public function test_task_can_updates()
    {
        $user = User::find(1);
        $task = Task::factory()->create([
            'title' => 'Old Title',
            'description' => 'Old description',
            'deadline' => now()->addDays(2),
            'status' => TaskStatusEnum::OPEN->value,
            'priority' => TaskPriorityEnum::LOW->value,
            'comment' => 'Old comment',
            'created_by' => $user->id,
        ]);

        $payload = [
            'title' => 'New Title',
            'description' => 'Updated description',
            'deadline' => '2025-09-16',
            'status' => TaskStatusEnum::IN_PROGRESS->value,
            'priority' => TaskPriorityEnum::HIGH->value,
            'comment' => 'Updated comment',
        ];

        $response = $this->putJson("/api/v1/tasks/update/{$task->id}", $payload);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => "{$task->id} - id li task jan'alandı",
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'New Title',
            'description' => 'Updated description',
            'status' => TaskStatusEnum::IN_PROGRESS->value,
            'priority' => TaskPriorityEnum::HIGH->value,
            'comment' => 'Updated comment',
        ]);

        $this->assertDatabaseHas('task_histories', [
            'task_id' => $task->id,
            'changed_by' => $user->id,
            'type' => TaskHistoryType::TaskUpdated,
        ]);
    }

    public function test_task_user_can_complete_task(): void
    {
        $user = User::find(1);
        $task = Task::factory()->create([
            'status' => TaskStatusEnum::OPEN,
            'created_by' => $user->id,
        ]);

        TaskUser::create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'status' => TaskStatusEnum::IN_PROGRESS->value,
            'accepted_at' => now(),
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
            'user_id' => $user->id,
            'status' => TaskStatusEnum::COMPLETED,
        ]);

        $this->assertDatabaseHas('task_histories', [
            'task_id' => $task->id,
            'changed_by' => $user->id,
            'type' => TaskHistoryType::TaskCompleted,
            'comment' => 'Задача выполнена. Комментарий: Task bolindi',
        ]);
    }
}