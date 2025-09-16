<?php

namespace Tests\Feature;

use App\Enums\TokenAbilityEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();
    }

    /**
     * Summary of test_user_can_login
     * @return void
     */
    public function test_user_can_login(): void
    {
        $this->withoutExceptionHandling();
        $data = [
            'email' => 'jack.ma@example.com',
            'password' => '12345678'
        ];

        $response = $this->postJson("/api/v1/auth/login", $data);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'access_token',
                    'refresh_token',
                    'at_expired_at',
                    'rf_expired_at',
                    'user'
                ]
            ]);
    }

    /**
     * Summary of test_user_can_get_profile
     * @return void
     */
    public function test_user_can_get_profile(): void
    {
        $user = User::find(1);
        Sanctum::actingAs($user, [TokenAbilityEnum::ACCESS_TOKEN->value]);

        $response = $this->getJson("/api/v1/auth/get-me");
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'first_name',
                    'last_name',
                    'patronymic',
                    'address',
                    'birth_date',
                    'position',
                    'status',
                    'phone',
                    'email',
                    'roles',
                    'permissions',
                ]
            ]);
    }

    /**
     * Summary of test_user_can_refresh_token
     * @return void
     */
    public function test_user_can_refresh_token(): void
    {
        $user = User::find(1);
        Sanctum::actingAs($user, [TokenAbilityEnum::ISSUE_ACCESS_TOKEN->value]);

        $response = $this->postJson("/api/v1/auth/refresh-token");
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'access_token',
                    'at_expired_at',
                ]
            ]);
    }

    /**
     * Summary of test_user_can_logout
     * @return void
     */
    public function test_user_can_logout(): void
    {
        $user = User::find(1);
        Sanctum::actingAs($user, [TokenAbilityEnum::ACCESS_TOKEN->value]);

        $response = $this->postJson("/api/v1/auth/logout");
        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'User logged out successfully'
            ]);
    }
}