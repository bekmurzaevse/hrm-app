<?php

namespace Tests\Feature\Project;

use App\Models\Stage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectStageTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();
    }

    /**
     * Summary of test_admin_manager_can_create_project_stage
     * @return void
     */
    public function test_admin_manager_can_create_project_stage()
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $data = [
            'stage_id' => 2,
            'title' => 'Test Stage',
            'description' => 'Test Description',
            'executor_id' => 1,
            'deadline' => '06-30-2025',
        ];

        $response = $this->postJson('/api/v1/projects/1/stage/create', $data);

        $response->assertJson([
            'status' => 201,
            'message' => 'Stage created',
        ]);

        $this->assertDatabaseHas('stages', [
            'project_id' => 1,
            'title' => 'Test Stage',
            'description' => 'Test Description',
            'executor_id' => 1,
        ]);
    }

    /**
     * Summary of test_admin_manager_can_update_project_stage
     * @return void
     */
    public function test_admin_manager_can_update_project_stage()
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $data = [
            'stage_id' => 2,
            'title' => 'Test Stage',
            'description' => 'Test Description',
            'executor_id' => 1,
            'deadline' => '06-30-2025',
        ];
        $stage = Stage::find(1);

        $response = $this->patchJson('/api/v1/projects/stage/1/update', $data);

        $response->assertJson([
            'status' => 200,
            'message' => 'Stage updated',
        ]);

        $this->assertDatabaseHas('stages', [
            'id' => $stage->id,
            'title' => 'Test Stage',
            'description' => 'Test Description',
            'executor_id' => 1,
        ]);
    }

    /**
     * Summary of test_delete_project_stage
     * @return void
     */
    public function test_admin_manager_can_delete_project_stage()
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $stage = Stage::find(1);

        $response = $this->deleteJson('/api/v1/projects/stage/delete/1');

        $response->assertJson([
            'status' => 200,
            'message' => 'Stage deleted',
        ]);

        $this->assertSoftDeleted('stages', [
            'id' => $stage->id,
        ]);
    }

    /**
     * Summary of test_admin_can_set_required_stage
     * @return void
     */
    public function test_admin_can_set_required_stage()
    {
        $user = User::role(['admin'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $stage = Stage::create([
            'title' => 'Test Stage',
            'description' => 'Test Description',
            'project_id' => 1,
            'deadline' => '06-30-2025',
            'created_by' => 1,
            'order' => 12,
            'executor_id' => 1,
            'is_required' => false,
        ]);

        $response = $this->patchJson('/api/v1/projects/stage/' . $stage->id . '/require');

        $response->assertJson([
            'status' => 200,
            'message' => 'Stage marked as required',
        ]);

        $this->assertDatabaseHas('stages', [
            'id' => $stage->id,
            'is_required' => true,
        ]);
    }

    /**
     * Summary of test_admin_manager_can_complete_stage
     * @return void
     */
    public function test_admin_manager_can_complete_stage(): void
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $stage = Stage::find(2);
        $data = [
            'candidate_count' => 5,
            'comment' => 'Test Comment',
        ];

        $response = $this->patchJson('/api/v1/projects/stage/' . $stage->id . '/complete', $data);

        $response->assertJson([
            'status' => 200,
            'message' => 'Stage completed',
        ]);

        $this->assertDatabaseHas('stage_completions', [
            'candidate_count' => 5,
            'comment' => 'Test Comment',
        ]);

        $this->assertDatabaseHas('stages', [
            'id' => $stage->id,
            'status' => 'completed',
        ]);
    }
}