<?php

namespace Tests\Feature\Vacancy;

use App\Models\Selection;
use App\Models\SelectionItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SelectionTest extends TestCase
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
     * Summary of test_user_can_get_all_selections
     * @return void
     */
    public function test_user_can_get_all_selections(): void
    {
        $response = $this->getJson("/api/v1/selections");
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
                            'creator',
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
     * Summary of test_user_can_view_list_of_selections
     * @return void
     */
    public function test_user_can_view_list_of_selections(): void
    {
        $response = $this->getJson("/api/v1/selections/list");
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                    ],
                ]
            ]);
    }

    /**
     * Summary of test_user_can_view_selection
     * @return void
     */
    public function test_user_can_view_selection(): void
    {
        $response = $this->getJson("/api/v1/selections/1");
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'title',
                    'created_at',
                    'created_by',
                    'candidates',
                    'candidates_count',
                    'external_count',
                    'statuses' => [
                        '*' => [
                            'id',
                            'title',
                            'order',
                        ]
                    ],
                    'items' => [
                        '*' => [
                            'item_id',
                            'status_values' => [
                                '0' => [
                                    'status_id',
                                    'value_id',
                                    'value',
                                    'source'
                                ],
                                '*' => [
                                    'status_id',
                                    'value_id',
                                    'value',
                                ]
                            ],
                        ]
                    ]
                ]
            ]);
    }

    /**
     * Summary of test_user_can_create_selection
     * @return void
     */
    public function test_user_can_create_selection(): void
    {
        $response = $this->postJson("/api/v1/selections/create", [
            'title' => 'test',
        ]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Selection created',
            ]);

        $this->assertDatabaseHas('selections', [
            'title' => 'test',
        ]);
    }

    /**
     * Summary of test_user_can_copy_selection
     * @return void
     */
    public function test_user_can_copy_selection(): void
    {
        $selection = Selection::with('items.statusValues')->find(1);

        $response = $this->postJson("/api/v1/selections/1/copy", [
            'title' => 'test',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Selection copied',
            ]);

        $this->assertDatabaseHas('selections', [
            'title' => 'test',
        ]);

        $copySelection = Selection::with('items.statusValues')->where('title', 'test')->first();

        $this->assertEquals(
            $selection->createdBy->id,
            $copySelection->createdBy->id
        );

        $this->assertEquals(
            $selection->items->only(['candidate_id', 'external_name']),
            $copySelection->items->only(['candidate_id', 'external_name'])
        );

        $this->assertEquals(
            $selection->statuses->only(['title', 'order']),
            $copySelection->statuses->only(['title', 'order'])
        );

        $this->assertEqualsCanonicalizing(
            $selection->items->flatMap->statusValues->only(['selection_item_id', 'selection_status_id', 'value'])->toArray(),
            $copySelection->items->flatMap->statusValues->only(['selection_item_id', 'selection_status_id', 'value'])->toArray()
        );

    }

    /**
     * Summary of test_user_can_delete_selection
     * @return void
     */
    public function test_user_can_delete_selection(): void
    {
        $selectionId = 1;
        $itemIds = SelectionItem::where('selection_id', $selectionId)->pluck('id')->toArray();

        $response = $this->deleteJson("/api/v1/selections/delete/" . $selectionId);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Selection deleted',
            ]);

        $this->assertDatabaseMissing('selections', [
            'id' => 1,
        ]);

        $this->assertDatabaseMissing('selection_statuses', [
            'selection_id' => 1,
        ]);

        $this->assertDatabaseMissing('selection_items', [
            'selection_id' => 1,
        ]);

        foreach ($itemIds as $itemId) {
            $this->assertDatabaseMissing('selection_status_values', [
                'selection_item_id' => $itemId,
            ]);
        }
    }

    /**
     * Summary of test_user_can_delete_selections
     * @return void
     */
    public function test_user_can_delete_selections(): void
    {
        $selectionIds = [1, 2];

        $itemIds = SelectionItem::whereIn('selection_id', $selectionIds)->pluck('id')->toArray();

        $response = $this->deleteJson("/api/v1/selections/delete/", [
            'ids' => $selectionIds,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Selections deleted',
            ]);

        foreach ($selectionIds as $selectionId) {
            $this->assertDatabaseMissing('selections', [
                'id' => $selectionId,
            ]);

            $this->assertDatabaseMissing('selection_statuses', [
                'selection_id' => $selectionId,
            ]);

            $this->assertDatabaseMissing('selection_items', [
                'selection_id' => $selectionId,
            ]);
        }

        foreach ($itemIds as $itemId) {
            $this->assertDatabaseMissing('selection_status_values', [
                'selection_item_id' => $itemId,
            ]);
        }
    }
}