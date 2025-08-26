<?php

namespace Tests\Feature\Vacancy;

use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VacancySkillTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();

        $user = User::find(1);
        $this->actingAs($user);
        // TODO: Need test with unauthorized user by role, actingAs * 
    }

    /**
     * Summary of test_vacancy_skills_can_create
     * @return void
     */
    public function test_vacancy_skills_can_create(): void
    {
        $vacancy = Vacancy::find(1);

        $response = $this->postJson('/api/v1/vacancies/1/skills/create', [
            'titles' => [
                'B2B',
                'CRM',
                'IT',
            ]
        ]);

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'message' => 'Vacancy\'s skills created',
        ]);

        $this->assertDatabaseHas('skills', [
            'title' => 'B2B',
            'skillable_id' => $vacancy->id,
            'skillable_type' => 'App\Models\Vacancy',
        ]);

        $this->assertDatabaseHas('skills', [
            'title' => 'CRM',
            'skillable_id' => $vacancy->id,
            'skillable_type' => 'App\Models\Vacancy',
        ]);

        $this->assertDatabaseHas('skills', [
            'title' => 'IT',
            'skillable_id' => $vacancy->id,
            'skillable_type' => 'App\Models\Vacancy',
        ]);
    }

    /**
     * Summary of test_vacancy_skills_can_update
     * @return void
     */
    public function test_vacancy_skills_can_update(): void
    {
        $vacancy = Vacancy::find(1);
        $skill = $vacancy->skills()->first();

        $response = $this->putJson('/api/v1/vacancies/1/skills/update/' . $skill->id, ['title' => 'CRM']);

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'message' => 'Vacancy\'s Skill Updated',
        ]);

        $this->assertDatabaseHas('skills', [
            'id' => $skill->id,
            'title' => 'CRM',
            'skillable_id' => $vacancy->id,
            'skillable_type' => 'App\Models\Vacancy',
        ]);
    }

    /**
     * Summary of test_vacancy_skill_can_delete
     * @return void
     */
    public function test_vacancy_skill_can_delete(): void
    {
        $vacancy = Vacancy::find(1);
        $skill = $vacancy->skills()->first();

        $response = $this->deleteJson('/api/v1/vacancies/1/skills/delete/' . $skill->id);

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'message' => "Id-{$skill->id} skill deleted"
        ]);

        $this->assertSoftDeleted('skills', [
            'id' => $skill->id
        ]);
    }
}