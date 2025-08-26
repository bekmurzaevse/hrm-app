<?php

namespace Tests\Feature;

use App\Helpers\FileUploadHelper;
use App\Models\Candidate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CandidateTest extends TestCase
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
     * Summary of test_candidate_can_get_all
     * @return void
     */
    public function test_candidate_can_get_all(): void
    {
        $response = $this->getJson("api/v1/candidates/");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message",
                "data" => [
                    "items" => [
                        "*" => [
                            "full_name",
                            "age",
                            "status",
                            "workplace",
                            "position",
                            "last_contact",
                            "city",
                            "experience",
                            "source",
                            "desired_salary",
                        ],
                    ],
                    "pagination" => [
                        "current_page",
                        "per_page",
                        "last_page",
                        "total",
                    ],
                ],
            ]);
    }

    /**
     * Summary of test_candidate_can_show
     * @return void
     */
    public function test_candidate_can_show(): void
    {
        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $candidateId = Candidate::inRandomOrder()->first()->id;

        $response = $this->getJson('/api/v1/candidates/' . $candidateId);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message",
                "data" => [
                    "main_info" => [
                        "full_name",
                        "birth_date",
                        "age",
                        "citizen",
                        "gender",
                        "status",
                    ],
                    "about" => [
                        "short_summary",
                        "achievments",
                        "comment",
                    ],
                    "contacts" => [
                        "*" => [
                            "id",
                            "title",
                            "value",
                            "description",
                        ],
                    ],
                    "skills" => [
                        "*" => [
                            "id",
                            "title",
                        ],
                    ],
                    "languages" => [
                        "*" => [
                            "id",
                            "title",
                            "degree",
                            "description",
                        ],
                    ],
                    "info" => [
                        "source",
                        "created_by",
                        "created_at",
                        "updated_at",
                    ],
                    "history",
                    "work_experience",
                    "desired_salary",
                    "esucations",
                    "files" => [
                        "*" => [
                            "id",
                            "name",
                            "path",
                            "size",
                            "created_at",
                            "updated_at",
                        ],
                    ],
                    "photo",
                    //  => [
                    // "name",
                    // "path",
                    // "size",
                    // ],
                    "description",
                ]
            ]);
    }

    /**
     * Summary of test_candidate_can_be_created
     * @return void
     */
    public function test_candidate_can_be_created(): void
    {
        $photo = UploadedFile::fake()->image('photo.jpg');

        $payload = [
            'first_name' => "Joe",
            'last_name' => "Biden",
            'patronymic' => "Putin",
            'birth_date' => "1950-11-24 00:00:00",
            'gender' => "male",
            'citizenship' => "USA",
            'country_residence' => "Uzbekistan",
            'region' => "Tashkent",
            'family_status' => "married",
            'family_info' => "Short text of family",
            'status' => "employed",
            'workplace' => "Microsoft",
            'position' => "Tecnical Director",
            'city' => "Tashkent",
            'address' => "1 Mikro rayon",
            'desired_salary' => 12000,
            'source' => "hh.uz",
            'experience' => 11,
            'short_summary' => "short summary",
            'achievments' => "diplom, Sertificate ...",
            'comment' => "some text",
            'description' => "description",
            'user_id' => 1,
            'photo' => $photo,
        ];

        $response = $this->postJson('api/v1/candidates/create', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);

        $this->assertDatabaseHas('candidates', [
            'first_name' => "Joe",
            'last_name' => "Biden",
            'patronymic' => "Putin",
            'birth_date' => "1950-11-24 00:00:00",
            'gender' => "male",
            'citizenship' => "USA",
            'country_residence' => "Uzbekistan",
            'region' => "Tashkent",
            'family_status' => "married",
            'family_info' => "Short text of family",
            'status' => "employed",
            'workplace' => "Microsoft",
            'position' => "Tecnical Director",
            'city' => "Tashkent",
            'address' => "1 Mikro rayon",
            'desired_salary' => 12000,
            'source' => "hh.uz",
            'experience' => 11,
            'short_summary' => "short summary",
            'achievments' => "diplom, Sertificate ...",
            'comment' => "some text",
            'description' => "description",
            'user_id' => 1,
        ]);
    }

    /**
     * Summary of test_candidate_can__updated_with_new_photo
     * @return void
     */
    public function test_candidate_can_updated_with_new_photo(): void
    {
        // $user = User::find(1)->first();
        // $this->actingAs($user);

        $candidate = Candidate::inRandomOrder()->first();

        $candidate->photo()->create([
            'name' => 'candidate.jpg',
            'path' => 'candidates/candidate.jpg',
            'type' => 'photo',
            'size' => 12345,
        ]);

        $photo = UploadedFile::fake()->image('candidate.jpg');
        $path = FileUploadHelper::file($photo, "candidatesPhotos/{$candidate->id}");

        $data = [
            'first_name' => "Joe new",
            'last_name' => "Biden new",
            'patronymic' => "Putin new",
            'birth_date' => "1950-11-24 00:00:00",
            'gender' => "male",
            'citizenship' => "USA",
            'country_residence' => "Uzbekistan",
            'region' => "Tashkent",
            'family_status' => "married",
            'family_info' => "Short text of family new",
            'status' => "employed",
            'workplace' => "ASUS",
            'position' => "CEO",
            'city' => "Samarkand",
            'address' => "Beruniy street",
            'desired_salary' => 8000,
            'source' => "hh.ru",
            'experience' => 3,
            'short_summary' => "short summary",
            'achievments' => "diplom, Sertificate ...",
            'comment' => "some text",
            'description' => "description",
            'user_id' => 1,
        ];

        if (Storage::disk('public')->exists($candidate->photo->path)) {
            Storage::disk('public')->delete($candidate->photo->path);
        }

        $response = $this->putJson('/api/v1/candidates/update/' . $candidate->id, $data);

        $candidate->photo()->update([
            'name' => $photo->getClientOriginalName(),
            'path' => $path['path'],
            'type' => "photo",
            'size' => $photo->getSize(),
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);

    }

    /**
     * Summary of test_candidate_can_be_deleted
     * @return void
     */
    public function test_candidate_can_be_deleted(): void
    {
        $candidate = Candidate::inRandomOrder()->first();

        $response = $this->deleteJson("/api/v1/candidates/delete/{$candidate->id}");

        $response->assertStatus(200);
    }

    /**
     * Summary of test_add_contact_to_candidate
     * @return void
     */
    public function test_add_contact_to_candidate()
    {
        $candidate = Candidate::inRandomOrder()->first();

        $data = [
            'title' => 'phone',
            'value' => '878347563',
        ];

        $response = $this->postJson("/api/v1/candidates/$candidate->id/contacts/create", $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_update_contact_to_candidate
     * @return void
     */
    public function test_update_contact_to_candidate()
    {
        $candidate = Candidate::inRandomOrder()->first();

        $candidate->contacts()->create([
            'title' => 'phone',
            'value' => '+998901234567111',
        ]);

        $data = [
            'title' => 'telegram',
            'value' => '@tgusername',
        ];

        $contactId = $candidate->contacts()->inRandomOrder()->first()->id;

        $response = $this->putJson("/api/v1/candidates/$candidate->id/contacts/update/$contactId", $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_delete_contact_in_candidate
     * @return void
     */
    public function test_delete_contact_in_candidate(): void
    {
        $candidate = Candidate::inRandomOrder()->first();

        $candidate->contacts()->create([
            'title' => 'phone',
            'value' => '+998901234567111',
        ]);

        $contactId = $candidate->contacts()->inRandomOrder()->first()->id;

        $response = $this->deleteJson("/api/v1/candidates/$candidate->id/contacts/delete/$contactId");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_add_education_to_candidate
     * @return void
     */
    public function test_add_education_to_candidate()
    {
        $candidate = Candidate::inRandomOrder()->first();

        $data = [
            'title' => "test title",
            'degree' => "test degree",
            'specialty' => 'test specialty',
            'start_year' => '2019',
            'end_year' => '2023',
            'candidate_id' => $candidate->id,
            'description' => 'test description',
        ];

        $response = $this->postJson("/api/v1/candidates/$candidate->id/educations/create", $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_update_education_to_candidate
     * @return void
     */
    public function test_update_education_to_candidate()
    {
        $candidate = Candidate::inRandomOrder()->first();

        $candidate->educations()->create([
            'title' => "test title new",
            'degree' => "test degree new",
            'specialty' => 'test specialty new',
            'start_year' => '2020',
            'end_year' => '2024',
            'candidate_id' => $candidate->id,
            'description' => 'test description new',
        ]);

        $data = [
            'title' => "test title",
            'degree' => "test degree",
            'specialty' => 'test specialty',
            'start_year' => '2019',
            'end_year' => '2023',
            'candidate_id' => $candidate->id,
            'description' => 'test description',
        ];

        $educationId = $candidate->educations()->inRandomOrder()->first()->id;

        $response = $this->putJson("/api/v1/candidates/$candidate->id/educations/update/$educationId", $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_delete_education_in_candidate
     * @return void
     */
    public function test_delete_education_in_candidate(): void
    {
        $candidate = Candidate::inRandomOrder()->first();

        $candidate->educations()->create([
            'title' => "test title",
            'degree' => "test degree",
            'specialty' => 'test specialty',
            'start_year' => '2019',
            'end_year' => '2023',
            'candidate_id' => $candidate->id,
            'description' => 'test description',
        ]);

        $educationId = $candidate->educations()->inRandomOrder()->first()->id;

        $response = $this->deleteJson("/api/v1/candidates/educations/delete/$educationId");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_add_experience_to_candidate
     * @return void
     */
    public function test_add_experience_to_candidate()
    {
        $candidate = Candidate::inRandomOrder()->first();

        $data = [
            'company' => "Goole",
            'position' => "Senior Software Ingeneer",
            'candidate_id' => $candidate->id,
            'start_work' => "2013",
            'end_work' => "2018",
            'description' => "test description",
        ];

        $response = $this->postJson("/api/v1/candidates/$candidate->id/experience/create", $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_update_experience_to_candidate
     * @return void
     */
    public function test_update_experience_to_candidate()
    {
        $candidate = Candidate::inRandomOrder()->first();

        $candidate->workExperience()->create([
            'company' => "Goole",
            'position' => "Senior Software Ingeneer",
            'candidate_id' => $candidate->id,
            'start_work' => "2013",
            'end_work' => "2018",
            'description' => "test description",
        ]);

        $data = [
            'company' => "Yandex new",
            'position' => "Intern new",
            'candidate_id' => $candidate->id,
            'start_work' => "2018",
            'end_work' => "2018",
            'description' => "test description",
        ];

        $workId = $candidate->workExperience()->inRandomOrder()->first()->id;

        $response = $this->putJson("/api/v1/candidates/$candidate->id/experience/update/$workId", $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_delete_experience_in_candidate
     * @return void
     */
    public function test_delete_experience_in_candidate(): void
    {
        $candidate = Candidate::inRandomOrder()->first();

        $candidate->workExperience()->create([
            'company' => "Goole",
            'position' => "Senior Software Ingeneer",
            'candidate_id' => $candidate->id,
            'start_work' => "2013",
            'end_work' => "2018",
            'description' => "test description",
        ]);

        $experienceId = $candidate->workExperience()->inRandomOrder()->first()->id;

        $response = $this->deleteJson("/api/v1/candidates/experience/delete/$experienceId");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_add_language_to_candidate
     * @return void
     */
    public function test_add_language_to_candidate()
    {
        $candidate = Candidate::inRandomOrder()->first();

        $data = [
            'title' => "France",
            'degree' => "Elemantary",
            'candidate_id' => $candidate->id,
            'description' => "test desc",
        ];

        $response = $this->postJson("/api/v1/candidates/$candidate->id/languages/create", $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_update_language_to_candidate
     * @return void
     */
    public function test_update_language_to_candidate()
    {
        $candidate = Candidate::inRandomOrder()->first();

        $candidate->languages()->create([
            'title' => "France",
            'degree' => "Elemantary",
            'candidate_id' => $candidate->id,
            'description' => "test desc",
        ]);

        $data = [
            'title' => "German",
            'degree' => "B1",
            'candidate_id' => $candidate->id,
            'description' => "test desc",
        ];

        $langId = $candidate->languages()->inRandomOrder()->first()->id;

        $response = $this->putJson("/api/v1/candidates/$candidate->id/languages/update/$langId", $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_delete_language_in_candidate
     * @return void
     */
    public function test_delete_language_in_candidate(): void
    {
        $candidate = Candidate::inRandomOrder()->first();

        $candidate->languages()->create([
            'title' => "France",
            'degree' => "Elemantary",
            'candidate_id' => $candidate->id,
            'description' => "test desc",
        ]);

        $langId = $candidate->languages()->inRandomOrder()->first()->id;

        $response = $this->deleteJson("/api/v1/candidates/languages/delete/$langId");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_add_skill_to_candidate
     * @return void
     */
    public function test_add_skill_to_candidate(): void
    {
        $candidate = Candidate::inRandomOrder()->first();

        $data = [
            'titles' => ['PHP', 'Laravel'],
        ];

        $response = $this->postJson("/api/v1/candidates/$candidate->id/skills/create", $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_update_skill_to_candidate
     * @return void
     */
    public function test_update_skill_to_candidate(): void
    {
        $candidate = Candidate::inRandomOrder()->first();

        $candidate->skills()->create([
            'title' => 'Java',
        ]);

        $data = [
            'title' => 'telegram',
        ];

        $skillId = $candidate->skills()->inRandomOrder()->first()->id;

        $response = $this->putJson("/api/v1/candidates/$candidate->id/skills/update/$skillId", $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_delete_skill_in_candidate
     * @return void
     */
    public function test_delete_skill_in_candidate(): void
    {

        $candidate = Candidate::inRandomOrder()->first();

        $candidate->skills()->create([
            'title' => 'test',
        ]);

        $skillId = $candidate->skills()->inRandomOrder()->first()->id;

        $response = $this->deleteJson("/api/v1/candidates/$candidate->id/skills/delete/$skillId");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_upload_file_to_candidate
     * @return void
     */
    public function test_upload_file_to_candidate(): void
    {
        $candidate = Candidate::inRandomOrder()->first();

        $file = UploadedFile::fake()->create(
            'document.pdf',
            200, // 200 KB
            'application/pdf'
        );

        $payload = [
            'files' => [$file],
        ];

        $response = $this->postJson("api/v1/candidates/$candidate->id/upload", $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    /**
     * Summary of test_delete_file_in_candidate
     * @return void
     */
    public function test_delete_file_in_candidate(): void
    {
        $candidate = Candidate::inRandomOrder()->first();

        $file = UploadedFile::fake()->create(
            'document.pdf',
            200, // 200 KB
            'application/pdf'
        );
        $payload = [
            'files' => [$file],
        ];

        $fileId = $candidate->files()->inRandomOrder()->first()->id;

        $response = $this->postJson("/api/v1/candidates/$candidate->id/deleteFile/$fileId");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }
}
