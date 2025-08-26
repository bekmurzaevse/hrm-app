<?php

namespace Tests\Feature;

use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TypeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();

        // $user - User::find(1);
        // $this->actingAs($user);
    }

    /**
     * Summary of test_type_can_get_all
     * @return void
     */
    public function test_type_can_get_all(): void
    {
        $response = $this->getJson("/api/v1/types");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'items' => [
                        [
                            'title',
                            'description',
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
     * Summary of test_type_can_show
     * @return void
     */
    public function test_type_can_show(): void
    {
        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $typeId = Type::inRandomOrder()->first()->id;

        $response = $this->getJson('/api/v1/types/' . $typeId);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'title',
                    'description',
                ]
            ]);
    }

    /**
     * Summary of test_type_can_create
     * @return void
     */
    public function test_type_can_create(): void
    {
        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $title = "test title";

        $data = [
            'title' => $title,
        ];

        $response = $this->postJson('/api/v1/types/create', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('types', [
            'title' => $title,
        ]);
    }

    /**
     * Summary of test_type_can_update
     * @return void
     */
    public function test_type_can_update(): void
    {
        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $type = Type::inRandomOrder()->first();

        $title = "update test title";

        $data = [
            'title' => $title,
        ];

        $response = $this->putJson('/api/v1/types/update/' . $type->id, $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);

        $this->assertDatabaseHas('types', [
            'title' => $title,
        ]);
    }

    /**
     * Summary of test_type_can_delete
     * @return void
     */
    public function test_type_can_delete(): void
    {
        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $typeId = Type::inRandomOrder()->first()->id;

        $response = $this->deleteJson('/api/v1/types/delete/' . $typeId);

        $response
            ->assertStatus(200);

        $this->assertSoftDeleted('types', [
            'id' => $typeId,
        ]);
    }
}
