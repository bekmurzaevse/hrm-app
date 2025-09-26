<?php

namespace Tests\Feature\Project;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();
    }

    /**
     * Summary of test_all_users_can_view_all_projects
     * @return void
     */
    public function test_all_users_can_view_all_projects(): void
    {
        $user = User::inRandomOrder()->first();
        Sanctum::actingAs($user, ['access-token']);

        $response = $this->getJson("/api/v1/projects");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'cards' => [
                        'total',
                        'in_progress',
                        'completed',
                        'total_price',
                    ],
                    'items' => [
                        [
                            'id',
                            'client_name',
                            'vacancy_title',
                            'executor',
                            'status',
                            'created_at',
                            'deadline',
                            'contract_number',
                            'contract_budget',
                            'progress',
                            'comment'
                        ]
                    ],
                    'pagination' => [
                        'current_page',
                        'per_page',
                        'last_page',
                        'total'
                    ]
                ]
            ]);
    }

    /**
     * Summary of test_all_users_can_view_one_project
     * @return void
     */
    public function test_all_users_can_view_one_project(): void
    {
        $user = User::inRandomOrder()->first();
        Sanctum::actingAs($user, ['access-token']);

        $project = Project::find(1);

        $response = $this->getJson("/api/v1/projects/1");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'status',
                    'stages',
                    'main_info',
                    'finance_info',
                    'requirements',
                    'files',
                ]
            ]);

        $response
            ->assertJsonPath('data.id', $project->id);
    }

    /**
     * Summary of test_admin_manager_can_create_project
     * @return void
     */
    public function test_admin_manager_can_create_project(): void
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $data = [
            'title' => 'test title',
            'client_id' => 1,
            'vacancy_id' => 1,
            'deadline' => '01-01-2023',
            'contract_number' => 'test contract number',
            'contract_budget' => 1000,
            // 'contract_currency' => 'USD',
            'description' => 'test description',
            'comment' => 'test comment',
            'performers' => [1, 2],
        ];

        $response = $this->postJson('/api/v1/projects/create', $data);

        $response
            ->assertStatus(201)
            ->assertJson([
                'status' => 201,
                'message' => 'Project created',
            ]);

        $this->assertDatabaseHas('projects', [
            'title' => $data['title'],
            'client_id' => $data['client_id'],
            'vacancy_id' => $data['vacancy_id'],
            'executor_id' => $user->id,
            'contract_number' => $data['contract_number'],
            'contract_budget' => $data['contract_budget'],
            // 'contract_currency' => $data['contract_currency'],
            'description' => $data['description'],
            'comment' => $data['comment'],
        ]);
    }

    /**
     * Summary of test_admin_manager_can_update_project
     * @return void
     */
    public function test_admin_manager_can_update_project(): void
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $data = [
            'title' => 'test title',
            'client_id' => 1,
            'vacancy_id' => 1,
            'executor_id' => 3,
            'deadline' => '01-01-2023',
            'contract_number' => 'test contract number',
            'contract_budget' => 1000,
            // 'contract_currency' => 'USD',
            'description' => 'test description',
            'comment' => 'test comment',
        ];

        $project = Project::find(1);

        $response = $this->putJson("/api/v1/projects/update/{$project->id}", $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Project updated',
            ]);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => $data['title'],
            'client_id' => $data['client_id'],
            'vacancy_id' => $data['vacancy_id'],
            'executor_id' => $data['executor_id'],
            'contract_number' => $data['contract_number'],
            'contract_budget' => $data['contract_budget'],
            // 'contract_currency' => $data['contract_currency'],
            'description' => $data['description'],
            'comment' => $data['comment'],
        ]);
    }

    /**
     * Summary of test_project_can_close
     * @return void
     */
    public function test_admin_manager_can_close_project(): void
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $project = Project::find(1);

        $comment = "test comment";

        $response = $this->patchJson("/api/v1/projects/{$project->id}/close", ['comment' => $comment]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Project closed',
            ]);

        $this->assertDatabaseHas('project_closures', [
            'project_id' => $project->id,
            'comment' => $comment,
        ]);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'status' => 'cancelled',
        ]);
    }

    /**
     * Summary of test_admin_manager_can_create_project_contract
     * @return void
     */
    public function test_admin_manager_can_create_project_contract(): void
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $project = Project::find(1);

        $response = $this->patchJson("/api/v1/projects/{$project->id}/create-contract", [
            'contract_number' => 'test contract number',
            'contract_budget' => 1000,
            // 'contract_currency' => 'USD', // TODO: add currency to Project
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'status' => 201,
                'message' => 'Contract created successfully for project',
            ]);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'contract_number' => 'test contract number',
            'contract_budget' => 1000,
            // 'contract_currency' => 'USD',
        ]);
    }

    /**
     * Summary of test_admin_manager_can_update_project_performers
     * @return void
     */
    public function test_admin_manager_can_update_project_executor(): void
    {
        $user = User::role(['admin'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $project = Project::find(1);


        $response = $this->patchJson("/api/v1/projects/{$project->id}/update-executor", [
            'executor_id' => 2,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Executor updated successfully for project',
            ]);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'executor_id' => 2,
        ]);

    }
}