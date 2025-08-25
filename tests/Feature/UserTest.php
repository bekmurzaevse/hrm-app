<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Storage::fake('public');
        $this->seed();

        // $user - User::find(1);
        // $this->actingAs($user);
    }

    /**
     * Summary of test_user_can_get_all
     * @return void
     */
    public function test_user_can_get_all(): void
    {
        $response = $this->getJson("/api/v1/users");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'items' => [
                        [
                            'full_name',
                            'position',
                            'role',
                            'status',
                            'email',
                            'phone',
                            'projects',
                            'created_at',
                            'updated_at',
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
     * Summary of test_user_can_show
     * @return void
     */
    public function test_user_can_show(): void
    {
        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $userId = User::inRandomOrder()->first()->id;

        $response = $this->getJson('/api/v1/users/' . $userId);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'first_name',
                    'last_name',
                    'patronymic',
                    'status',
                    'contact_info',
                    'work_info',
                    'projects',
                    'activities',
                    'stats',
                ]
            ]);
    }

    /**
     * Summary of test_user_can_create
     * @return void
     */
    public function test_user_can_create(): void
    {
        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $firstName = "Murk";
        $lastName = "Zuckerberg";
        $patronymic = "Zuckerberg";
        $birthDate = "1985-12-25";
        $address = "San-Fransisco";
        $position = "CEO";
        $phone = "998997654382";
        $email = "murk@yandex.ru";
        $status = "working";
        $password = "123456";

        $data = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'patronymic' => $patronymic,
            'birth_date' => $birthDate,
            'address' => $address,
            'position' => $position,
            'phone' => $phone,
            'email' => $email,
            'status' => $status,
            'password' => $password,
        ];

        $response = $this->postJson('/api/v1/users/create', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'patronymic' => $patronymic,
            'birth_date' => $birthDate,
            'address' => $address,
            'position' => $position,
            'phone' => $phone,
            'email' => $email,
            'status' => $status,
        ]);
    }

    /**
     * Summary of test_user_can_update
     * @return void
     */
    public function test_user_can_update(): void
    {
        $this->withoutExceptionHandling();

        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $user = User::inRandomOrder()->first();

        $firstName = "new Murk";
        $lastName = "new Zuckerberg";
        $patronymic = "new Zuckerberg";
        $birthDate = "1995-10-25";
        $address = "California";
        $position = "Director";
        $phone = "998997654384";
        $email = "zuckerberg@yandex.ru";
        $status = "working";
        $password = "123456";

        $data = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'patronymic' => $patronymic,
            'birth_date' => $birthDate,
            'address' => $address,
            'position' => $position,
            'phone' => $phone,
            'email' => $email,
            'status' => $status,
            'password' => $password,
        ];

        $response = $this->putJson('/api/v1/users/update/' . $user->id, $data);

        $response
            ->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'patronymic' => $patronymic,
            'birth_date' => $birthDate,
            'address' => $address,
            'position' => $position,
            'phone' => $phone,
            'email' => $email,
            'status' => $status,
        ]);
    }

    /**
     * Summary of test_user_can_delete
     * @return void
     */
    public function test_user_can_delete(): void
    {
        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $userId = User::inRandomOrder()->first()->id;

        $response = $this->deleteJson('/api/v1/users/delete/' . $userId);

        $response
            ->assertStatus(200);

        $this->assertSoftDeleted('users', [
            'id' => $userId,
        ]);
    }

    /**
     * Summary of test_update_status_in_user
     * @return void
     */
    public function test_update_status_in_user(): void
    {
        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $user = User::inRandomOrder()->first();

        $status = "working";

        $data = [
            'status' => $status,
        ];

        $response = $this->putJson("/api/v1/users/$user->id/updateStatus", $data);

        $response
            ->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'status' => $status,
        ]);
    }
}
