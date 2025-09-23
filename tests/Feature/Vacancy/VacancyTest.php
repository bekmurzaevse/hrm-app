<?php

namespace Tests\Feature\Vacancy;

use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class VacancyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();
    }

    /**
     * View all vacancies by all users
     * @return void
     */
    public function test_all_user_can_view_all_vacancies(): void
    {
        $user = User::inRandomOrder()->first();
        Sanctum::actingAs($user, ['access-token']);

        $response = $this->getJson("/api/v1/vacancies");
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'items' => [
                        [
                            'id',
                            'title',
                            'position_count',
                            'client_name',
                            'salary',
                            'region',
                            'district',
                            'created_by',
                            'created_at',
                            'status'
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
     * View single vacancy by all users
     * @return void
     */
    public function test_all_user_can_view_vacancy(): void
    {
        $user = User::inRandomOrder()->first();
        Sanctum::actingAs($user, ['access-token']);

        $vacancy = Vacancy::find(1);

        $response = $this->getJson("/api/v1/vacancies/1");
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'main_info' => [
                        'title',
                        'client',
                        'salary',
                        'region',
                        'district',
                        'type_employment',
                        'work_experience',
                        'position_count',
                        'bonus',
                        'probation',
                        'probation_salary',
                    ],
                    'detail' => [
                        'desription',
                        'requirements',
                        'responsibilities',
                        'work_conditions',
                        'benefits'
                    ],
                    'skills' => [
                        '*' => [
                            'id',
                            'title',
                        ]
                    ],
                    'contact_info' => [
                        'contact_person',
                        'position',
                        'phone',
                        'email',
                    ],
                    'status',
                    'position_count',
                    'region',
                    'district',
                    'key_data' => [
                        'created_at',
                        'created_by'
                    ],
                    'files' => [
                        '*' => [
                            'id',
                            'name',
                            'type',
                            'size',
                            'created_at',
                            'download_url',
                        ]
                    ]
                ]
            ]);
        $response
            ->assertJsonPath('data.id', $vacancy->id)
            ->assertJsonPath('data.main_info.title', $vacancy->title);
    }

    /**
     * Create vacancy by admin and manager
     * @return void
     */
    public function test_admin_manager_can_create_vacancy(): void
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $data = [
            'title' => 'Test vacancy',
            'client_id' => 1,
            'department' => 'Test department',
            'district_id' => 20,
            'type_employment' => 'office',
            'work_schedule' => 'full_time',
            'work_experience' => 'no_experience',
            'education' => 'secondary',
            'status' => 'not_active',
            'position_count' => 2,
            'salary' => '1000-2000',
            'currency' => 'USD',
            'period' => 'month',
            'bonus' => 'Test bonus',
            'probation' => '6 месяцев',
            'probation_salary' => '1000',
            'description' => 'Test description',
            'requirements' => 'Test requirements',
            'responsibilities' => 'Test responsibilities',
            'work_conditions' => 'Test work conditions',
            'benefits' => 'Test benefits',
        ];

        $response = $this->postJson("/api/v1/vacancies/create", $data);

        $response
            ->assertStatus(201)
            ->assertExactJson([
                'status' => 201,
                'message' => 'Vacancy created',
            ]);

        $this->assertDatabaseHas('vacancies', [
            'title' => $data['title'],
            'client_id' => $data['client_id'],
            'department' => $data['department'],
            'district_id' => 20,
            'type_employment' => 'office',
            'work_schedule' => 'full_time',
            'work_experience' => 'no_experience',
            'education' => 'secondary',
            'status' => 'not_active',
            'position_count' => $data['position_count'],
            'created_by' => $user->id,
            'salary_from' => '1000',
            'salary_to' => '2000',
            'currency' => 'USD',
            'period' => 'month',
            'bonus' => $data['bonus'],
            'probation' => $data['probation'],
            'probation_salary' => $data['probation_salary'],
            'description' => $data['description'],
            'requirements' => $data['requirements'],
            'responsibilities' => $data['responsibilities'],
            'work_conditions' => $data['work_conditions'],
            'benefits' => $data['benefits'],
        ]);
    }

    /**
     * Update vacancy by admin and manager
     * @return void
     */
    public function test_admin_manager_can_update_vacancy(): void
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $vacancy = Vacancy::find(1);

        $data = [
            'title' => 'Test vacancy',
            'client_id' => 1,
            'department' => 'Test department',
            'district_id' => 20,
            'type_employment' => 'office',
            'work_schedule' => 'full_time',
            'work_experience' => 'no_experience',
            'education' => 'secondary',
            'status' => 'not_active',
            'position_count' => 2,
            'salary' => '1000-2000',
            'currency' => 'USD',
            'period' => 'month',
            'bonus' => 'Test bonus',
            'probation' => '6 месяцев',
            'probation_salary' => '1000',
            'description' => 'Test description',
            'requirements' => 'Test requirements',
            'responsibilities' => 'Test responsibilities',
            'work_conditions' => 'Test work conditions',
            'benefits' => 'Test benefits',
        ];

        $response = $this->putJson("/api/v1/vacancies/update/{$vacancy->id}", $data);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'status' => 200,
                'message' => 'Vacancy updated',
            ]);

        $this->assertDatabaseHas('vacancies', [
            'id' => $vacancy->id,
            'title' => $data['title'],
            'client_id' => $data['client_id'],
            'department' => $data['department'],
            'district_id' => 20,
            'type_employment' => 'office',
            'work_schedule' => 'full_time',
            'work_experience' => 'no_experience',
            'education' => 'secondary',
            'status' => 'not_active',
            'position_count' => $data['position_count'],
            'created_by' => $user->id,
            'salary_from' => 1000,
            'salary_to' => 2000,
            'currency' => 'USD',
            'period' => 'month',
            'bonus' => $data['bonus'],
            'probation' => $data['probation'],
            'probation_salary' => 1000,
            'description' => $data['description'],
            'requirements' => $data['requirements'],
            'responsibilities' => $data['responsibilities'],
            'work_conditions' => $data['work_conditions'],
            'benefits' => $data['benefits'],
        ]);
    }

    /**
     * Delete vacancy by admin and manager
     * @return void
     */
    public function test_admin_manager_can_delete_vacancy(): void
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $vacancy = Vacancy::find(1);

        $response = $this->deleteJson("/api/v1/vacancies/delete/{$vacancy->id}");

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'status' => 200,
                'message' => 'Vacancy Deleted',
            ]);

        $this->assertSoftDeleted('vacancies', [
            'id' => $vacancy->id,
        ]);

        $this->assertSoftDeleted('skills', [
            'skillable_id' => $vacancy->id,
            'skillable_type' => 'App\Models\Vacancy',
        ]);
    }
}
