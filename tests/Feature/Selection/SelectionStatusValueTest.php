<?php

namespace Tests\Feature\Selection;

use App\Models\SelectionStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SelectionStatusValueTest extends TestCase
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

    /**
     * Summary of test_user_can_add_value
     * @return void
     */
    public function test_user_can_add_value(): void
    {
        $status = SelectionStatus::create([
            'selection_id' => 2,
            'title' => 'test status',
        ]);

        $response = $this->postJson("/api/v1/selections/2/status-values", [
            'selection_item_id' => 3,
            'selection_status_id' => $status->id,
            'value' => 'test',
        ]);

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'message' => 'Selection Status Value created',
        ]);

        $this->assertDatabaseHas('selection_status_values', [
            'selection_item_id' => 3,
            'selection_status_id' => $status->id,
            'value' => 'test',
        ]);
    }

    /**
     * Summary of test_user_can_update_value
     * @return void
     */
    public function test_user_can_update_value(): void
    {
        $response = $this->putJson("/api/v1/selections/2/status-values/13", [
            'value' => 'test',
        ]);

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'message' => 'Selection Status Value updated',
        ]);
    }
}