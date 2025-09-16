<?php

namespace Tests\Feature\Selection;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SelectionItemTest extends TestCase
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
     * Summary of test_user_can_add_candidates_to_selections
     * @return void
     */
    public function test_user_can_add_candidates_to_selections(): void
    {
        $response = $this->postJson("/api/v1/selections/attach-candidates", [
            'selections' => [5, 6],
            'candidates' => [1, 2]
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'attached_count',
                'duplicate_count',
                'duplicates'
            ]
        ]);
    }

    /**
     * Summary of test_user_can_add_external_candidate_to_selection
     * @return void
     */
    public function test_user_can_add_external_candidate_to_selection()
    {
        $response = $this->postJson("/api/v1/selections/1/add-external-candidates", [
            'external_candidates' => ["Kamolov Bekzod"]
        ]);

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'message' => 'External candidate added to selection'
        ]);

        $this->assertDatabaseHas('selection_items', [
            'selection_id' => 1,
            'external_name' => 'Kamolov Bekzod'
        ]);
    }

    /**
     * Summary of test_user_can_add_external_candidates_to_selection
     * @return void
     */
    public function test_user_can_add_external_candidates_to_selection()
    {
        $data = [
            'Kamolov Bekzod',
            'Umarov Umar',
            'Tolipov Hasan'
        ];

        $response = $this->postJson("/api/v1/selections/1/add-external-candidates", [
            'external_candidates' => $data
        ]);

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'message' => 'External candidates added to selection'
        ]);

        foreach ($data as $name) {
            $this->assertDatabaseHas('selection_items', [
                'selection_id' => 1,
                'external_name' => $name
            ]);
        }
    }

    /**
     * Summary of test_user_can_detach_candidates_from_selection
     * @return void
     */
    public function test_user_can_detach_candidates_from_selection(): void
    {
        $itemIds = [1, 2];

        $response = $this->postJson("/api/v1/selections/1/detach-candidates", [
            'items' => $itemIds
        ]);

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'message' => 'Candidates detached from selection'
        ]);

        foreach ($itemIds as $itemId) {
            $this->assertDatabaseMissing('selection_items', [
                'id' => $itemId
            ]);

            $this->assertDatabaseMissing('selection_status_values', [
                'selection_item_id' => $itemId,
            ]);
        }
    }
}