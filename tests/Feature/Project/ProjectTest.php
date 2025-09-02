<?php

namespace Tests\Feature\Vacancy;

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

        $user = User::find(1);
        Sanctum::actingAs($user, ['access-token']);
        // TODO: Need test with unauthorized user by role, actingAs * 
    }

    /**
     * Summary of test_project_can_view_all
     * @return void
     */
    public function test_project_can_view_all(): void
    {
        $response = $this->getJson("/api/v1/projects");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'filter' => [
                        'user' => [
                            '*' => [
                                'id',
                                'first_name',
                                'last_name',
                                'patronymic'
                            ]
                        ]
                    ],
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
                            'status',
                            'created_at',
                            'deadline',
                            'performers',
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
     * Summary of test_project_can_view_one
     * @return void
     */
    public function test_project_can_view_one(): void
    {
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
     * Summary of test_project_can_create
     * @return void
     */
    public function test_project_can_create(): void
    {
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
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Project created',
            ]);

        $this->assertDatabaseHas('projects', [
            'title' => $data['title'],
            'client_id' => $data['client_id'],
            'vacancy_id' => $data['vacancy_id'],
            'contract_number' => $data['contract_number'],
            'contract_budget' => $data['contract_budget'],
            // 'contract_currency' => $data['contract_currency'],
            'description' => $data['description'],
            'comment' => $data['comment'],
        ]);
    }

    /**
     * Summary of test_project_can_update
     * @return void
     */
    public function test_project_can_update(): void
    {
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

        $project = Project::find(1);

        $response = $this->putJson("/api/v1/projects/update/{$project->id}", $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => '1-Project updated',
            ]);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => $data['title'],
            'client_id' => $data['client_id'],
            'vacancy_id' => $data['vacancy_id'],
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
    public function test_project_can_close(): void
    {
        $project = Project::find(1);

        $comment = "test comment";

        $response = $this->patchJson("/api/v1/projects/{$project->id}/close", ['comment' => $comment]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => '1-Project closed',
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
     * Summary of test_project_can_create_contract
     * @return void
     */
    public function test_project_can_create_contract(): void
    {
        $project = Project::find(1);

        $response = $this->patchJson("/api/v1/projects/{$project->id}/create-contract", [
            'contract_number' => 'test contract number',
            'contract_budget' => 1000,
            // 'contract_currency' => 'USD',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Contract created successfully for project-1',
            ]);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'contract_number' => 'test contract number',
            'contract_budget' => 1000,
            // 'contract_currency' => 'USD',
        ]);
    }

    /**
     * Summary of test_project_performers_can_update
     * @return void
     */
    public function test_project_performers_can_update(): void
    {
        $project = Project::find(1);
        $data = [
            'performers' => [1, 2],
        ];

        $response = $this->putJson("/api/v1/projects/{$project->id}/update-performers", $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Performers updated successfully for project-1',
            ]);

        $this->assertDatabaseHas('project_user', [
            'project_id' => $project->id,
            'user_id' => 1,
        ]);
        $this->assertDatabaseHas('project_user', [
            'project_id' => $project->id,
            'user_id' => 2,
        ]);
    }
}