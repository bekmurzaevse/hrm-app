<?php

namespace Tests\Feature\Project;

use App\Models\StageTask;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectStageTaskTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();

        $user = User::find(1);
        Sanctum::actingAs($user, ['access-token']);
        // TODO: Need test with unauthorized user by role, actingAs * 
    }

    /**
     * Summary of test_create_project_stage_task
     * @return void
     */
    public function test_create_project_stage_task()
    {
        $data = [
            'stage_id' => 2,
            'title' => 'Test Stage',
            'description' => 'Test Description',
            'executor_id' => 1,
            'priority' => 'low',
            'deadline' => '06-30-2025',
        ];

        $response = $this->postJson('/api/v1/projects/stage/task/create', $data);

        $response->assertJson([
            'status' => 200,
            'message' => "Stage's task created",
        ]);

        $this->assertDatabaseHas('stage_tasks', [
            'stage_id' => 2,
            'title' => 'Test Stage',
            'description' => 'Test Description',
            'executor_id' => 1,
            'priority' => 'low',
        ]);
    }

    /**
     * Summary of test_update_project_stage_task
     * @return void
     */
    public function test_update_project_stage_task()
    {
        $data = [
            'stage_id' => 2,
            'title' => 'Test Stage',
            'description' => 'Test Description',
            'executor_id' => 1,
            'priority' => 'low',
            'deadline' => '06-30-2025',
        ];

        $response = $this->putJson('/api/v1/projects/stage/task/3/update', $data);

        $response->assertJson([
            'status' => 200,
            'message' => "Stage's task updated",
        ]);

        $this->assertDatabaseHas('stage_tasks', [
            'id' => 3,
            'title' => 'Test Stage',
            'description' => 'Test Description',
            'executor_id' => 1,
            'priority' => 'low',
        ]);
    }

    /**
     * Summary of test_delete_project_stage_task
     * @return void
     */
    public function test_delete_project_stage_task()
    {
        $stage = StageTask::find(1);

        $response = $this->deleteJson('/api/v1/projects/stage/task/1/delete');

        $response->assertJson([
            'status' => 200,
            'message' => "Stage's task deleted",
        ]);

        $this->assertSoftDeleted('stage_tasks', [
            'id' => $stage->id,
        ]);
    }
}