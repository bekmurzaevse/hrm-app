<?php

namespace Tests\Feature\Vacancy;

use App\Models\Selection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SelectionStatusTest extends TestCase
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
     * Summary of test_user_can_view_list_of_status
     * @return void
     */
    public function test_user_can_view_list_of_status(): void
    {
        $response = $this->getJson("/api/v1/selections/2/statuses/list");

        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'title',
                ]
            ]
        ]);
    }

    /**
     * Summary of test_user_can_add_status
     * @return void
     */
    public function test_user_can_add_status(): void
    {
        $response = $this->postJson("/api/v1/selections/2/statuses", [
            'title' => 'test',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Selection status created',
            ]);

        $this->assertDatabaseHas('selection_statuses', [
            'title' => 'test',
            'selection_id' => 2
        ]);
    }

    /**
     * Summary of test_user_can_update_status
     * @return void
     */
    public function test_user_can_update_status(): void
    {
        $response = $this->putJson("/api/v1/selections/2/statuses/7", [
            'title' => 'test',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Selection status updated',
            ]);

        $this->assertDatabaseHas('selection_statuses', [
            'id' => 7,
            'title' => 'test',
            'selection_id' => 2
        ]);
    }

    /**
     * Summary of test_user_can_delete_status
     * @return void
     */
    public function test_user_can_delete_status(): void
    {
        $response = $this->deleteJson("/api/v1/selections/2/statuses/7");

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Selection status deleted',
            ]);

        $this->assertDatabaseMissing('selection_statuses', [
            'id' => 7,
            'selection_id' => 2
        ]);
    }
}