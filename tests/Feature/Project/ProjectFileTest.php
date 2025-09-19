<?php

namespace Tests\Feature\Project;

use App\Helpers\FileUploadHelper;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectFileTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();
    }

    /**
     * Summary of test_admin_manager_can_upload_project_file
     * @return void
     */
    public function test_admin_manager_can_upload_project_file()
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $project = Project::find(1);
        $file = UploadedFile::fake()->create('document.pdf', 1024, 'application/pdf');

        $response = $this->postJson('/api/v1/projects/' . $project->id . '/upload', [
            'file' => $file,
            'type' => 'document'
        ]);

        $response->assertStatus(201)->assertJson([
            "status" => 201,
            "message" => "Uploaded file to Project"
        ]);

        $this->assertDatabaseHas('files', [
            'fileable_id' => $project->id,
            'fileable_type' => 'App\Models\Project',
            'name' => 'document.pdf'
        ]);
    }

    /**
     * Summary of test_all_users_can_download_project_file
     * @return void
     */
    public function test_all_users_can_download_project_file()
    {
        $user = User::inRandomOrder()->first();
        Sanctum::actingAs($user, ['access-token']);

        $project = Project::find(1);

        $file = UploadedFile::fake()->create('document.pdf', 1024, 'application/pdf');
        $uploadedFile = FileUploadHelper::file($file, "projects/1");

        $projectFile = $project->files()->create([
            'name' => $uploadedFile['name'],
            'path' => $uploadedFile['path'],
            'size' => $uploadedFile['size'],
            'type' => 'document',
        ]);

        $response = $this->getJson('/api/v1/projects/' . $project->id . '/download/' . $projectFile->id);

        $response->assertStatus(200)
            ->assertHeader('Content-Disposition', 'attachment; filename=document.pdf');
    }

    /**
     * Summary of test_admin_manager_can_delete_project_file
     * @return void
     */
    public function test_admin_manager_can_delete_project_file()
    {
        $user = User::role(['admin', 'manager'])
            ->inRandomOrder()
            ->first();
        Sanctum::actingAs($user, ['access-token']);

        $project = Project::find(1);

        $file = UploadedFile::fake()->create('document.pdf', 1024, 'application/pdf');
        $uploadedFile = FileUploadHelper::file($file, "projects/1");

        $projectFile = $project->files()->create([
            'name' => $uploadedFile['name'],
            'path' => $uploadedFile['path'],
            'size' => $uploadedFile['size'],
            'type' => 'document',
        ]);

        $response = $this->deleteJson('/api/v1/projects/' . $project->id . '/delete/' . $projectFile->id);

        $response->assertStatus(200)
            ->assertJson([
                "status" => 200,
                "message" => "File deleted successfully"
            ]);

        $this->assertSoftDeleted('files', [
            'id' => $projectFile->id
        ]);
    }
}