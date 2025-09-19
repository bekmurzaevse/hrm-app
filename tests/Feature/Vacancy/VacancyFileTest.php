<?php

namespace Tests\Feature\Vacancy;

use App\Helpers\FileUploadHelper;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class VacancyFileTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();
    }

    /**
     * Summary of test_admin_manager_can_upload_file_for_vacancy
     * @return void
     */
    public function test_admin_manager_can_upload_file_for_vacancy()
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $vacancy = Vacancy::find(1);
        $file = UploadedFile::fake()->create('document.pdf', 1024, 'application/pdf');

        $response = $this->postJson('/api/v1/vacancies/' . $vacancy->id . '/upload', [
            'file' => $file,
            'type' => 'document'
        ]);

        $response->assertStatus(200)->assertJson([
            "status" => 200,
            "message" => "Uploaded file to Vacancy"
        ]);

        $this->assertDatabaseHas('files', [
            'fileable_id' => $vacancy->id,
            'fileable_type' => 'App\Models\Vacancy',
            'name' => 'document.pdf'
        ]);
    }

    /**
     * Summary of test_all_users_can_download_file_for_vacancy
     * @return void
     */
    public function test_all_users_can_download_file_for_vacancy()
    {
        $user = User::inRandomOrder()->first();
        Sanctum::actingAs($user, ['access-token']);

        $vacancy = Vacancy::find(1);

        $file = UploadedFile::fake()->create('document.pdf', 1024, 'application/pdf');
        $uploadedFile = FileUploadHelper::file($file, "vacancies/1");

        $vacancyFile = $vacancy->files()->create([
            'name' => $uploadedFile['name'],
            'path' => $uploadedFile['path'],
            'size' => $uploadedFile['size'],
            'type' => 'document',
        ]);

        $response = $this->getJson('/api/v1/vacancies/' . $vacancy->id . '/download/' . $vacancyFile->id);

        $response->assertStatus(200)
            ->assertHeader('Content-Disposition', 'attachment; filename=document.pdf');
    }

    /**
     * Summary of test_all_users_can_show_file_for_vacancy
     * @return void
     */
    public function test_all_users_can_show_file_for_vacancy()
    {
        $user = User::inRandomOrder()->first();
        Sanctum::actingAs($user, ['access-token']);

        $vacancy = Vacancy::find(1);

        $file = UploadedFile::fake()->create('document.pdf', 1024, 'application/pdf');
        $uploadedFile = FileUploadHelper::file($file, "vacancies/1");

        $vacancyFile = $vacancy->files()->create([
            'name' => $uploadedFile['name'],
            'path' => $uploadedFile['path'],
            'size' => $uploadedFile['size'],
            'type' => 'document',
        ]);

        $response = $this->getJson('/api/v1/vacancies/' . $vacancy->id . '/file/' . $vacancyFile->id);

        $response->assertStatus(200)
            ->assertHeader('Content-Disposition', 'inline; filename="document.pdf"');
    }

    /**
     * Summary of test_admin_manager_can_delete_file_for_vacancy
     * @return void
     */
    public function test_admin_manager_can_delete_file_for_vacancy()
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $vacancy = Vacancy::find(1);

        $file = UploadedFile::fake()->create('document.pdf', 1024, 'application/pdf');
        $uploadedFile = FileUploadHelper::file($file, "vacancies/1");

        $vacancyFile = $vacancy->files()->create([
            'name' => $uploadedFile['name'],
            'path' => $uploadedFile['path'],
            'size' => $uploadedFile['size'],
            'type' => 'document',
        ]);

        $response = $this->deleteJson('/api/v1/vacancies/' . $vacancy->id . '/delete/' . $vacancyFile->id);

        $response->assertStatus(200)
            ->assertJson([
                "status" => 200,
                "message" => "File deleted successfully"
            ]);

        $this->assertSoftDeleted('files', [
            'id' => $vacancyFile->id
        ]);
    }
}