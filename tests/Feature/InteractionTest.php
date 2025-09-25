<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\Interaction;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class InteractionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();
    }

    /**
     * Summary of test_interaction_can_get_all
     * @return void
     */
    public function test_interaction_can_get_all(): void
    {
        $user = User::role(['recruiter'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $response = $this->getJson("/api/v1/interactions");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_type_can_show
     * @return void
     */
    public function test_type_can_show(): void
    {
        $user = User::role(['recruiter'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $typeId = Type::inRandomOrder()->first()->id;

        $response = $this->getJson('/api/v1/types/' . $typeId);

        $response
            ->assertStatus(200);
    }

    /**
     * Summary of test_interaction_can_create
     * @return void
     */
    public function test_interaction_can_create(): void
    {
        $user = User::role(['recruiter'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $value = "test";
        $description = "description";
        $candidateId = Candidate::inRandomOrder()->first()->id;
        $typeId = Type::inRandomOrder()->first()->id;

        $data = [
            'value' => $value,
            'type_id' => $typeId,
            'candidate_id' => $candidateId,
            'description' => $description,
        ];

        $response = $this->postJson('/api/v1/interactions/create', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('interactions', [
            'value' => $value,
            'type_id' => $typeId,
            'candidate_id' => $candidateId,
            'user_id' => $user->id,
            'description' => $description,
        ]);
    }

    /**
     * Summary of test_interaction_can_update
     * @return void
     */
    public function test_interaction_can_update(): void
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $interaction = Interaction::inRandomOrder()->first();

        $value = "new test";
        $description = "new description";
        $candidateId = Candidate::inRandomOrder()->first()->id;
        $typeId = Type::inRandomOrder()->first()->id;

        $data = [
            'value' => $value,
            'type_id' => $typeId,
            'candidate_id' => $candidateId,
            'user_id' => $user->id,
            'description' => $description,
        ];

        $response = $this->putJson('/api/v1/interactions/update/' . $interaction->id, $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);

        $this->assertDatabaseHas('interactions', [
            'value' => $value,
            'type_id' => $typeId,
            'candidate_id' => $candidateId,
            'user_id' => $user->id,
            'description' => $description,
        ]);
    }

    /**
     * Summary of test_interaction_can_delete
     * @return void
     */
    public function test_interaction_can_delete(): void
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $interactionId = Interaction::inRandomOrder()->first()->id;

        $response = $this->deleteJson('/api/v1/interactions/delete/' . $interactionId);

        $response
            ->assertStatus(200);

        $this->assertSoftDeleted('interactions', [
            'id' => $interactionId,
        ]);
    }
}
