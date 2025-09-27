<?php

namespace Tests\Feature;

use App\Enums\User\UserStatusEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();

        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);
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
                            'roles',
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
        $firstName = "Murk";
        $lastName = "Zuckerberg";
        $patronymic = "Zuckerberg";
        $birthDate = "1985-12-25";
        $address = "San-Fransisco";
        $position = "CEO";
        $phone = "998997654382";
        $email = "murk@yandex.ru";
        $status = UserStatusEnum::WORKING;
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
        $user = User::inRandomOrder()->first();

        $status = UserStatusEnum::WORKING->value;

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
