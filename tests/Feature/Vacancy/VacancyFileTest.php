<?php

namespace Tests\Feature\Vacancy;

use App\Helpers\FileUploadHelper;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VacancyFileTest extends TestCase
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
     * Summary of test_vacancy_file_upload
     * @return void
     */
    public function test_vacancy_file_upload()
    {
        $vacancy = Vacancy::find(1);
        $file = UploadedFile::fake()->create('document.pdf', 1024, 'application/pdf');

        $response = $this->postJson('/api/v1/vacancies/' . $vacancy->id . '/upload', [
            'file' => $file,
            'type' => 'document'
        ]);

        $response->assertStatus(200)->assertJson([
            "status" => 200,
            "message" => "Uploaded file to Vacancy-1"
        ]);

        $this->assertDatabaseHas('files', [
            'fileable_id' => $vacancy->id,
            'fileable_type' => 'App\Models\Vacancy',
            'name' => 'document.pdf'
        ]);
    }

    /**
     * Summary of test_vacancy_file_download
     * @return void
     */
    public function test_vacancy_file_download()
    {
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
     * Summary of test_vacancy_file_show
     * @return void
     */
    public function test_vacancy_file_show()
    {
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
     * Summary of test_vacancy_file_delete
     * @return void
     */
    public function test_vacancy_file_delete()
    {
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