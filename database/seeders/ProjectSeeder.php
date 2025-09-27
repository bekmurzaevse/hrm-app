<?php

namespace Database\Seeders;

use App\Helpers\FileUploadHelper;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project1 = Project::create([
            'title' => 'Sample Project',
            'client_id' => 1,
            'vacancy_id' => 1,
            'deadline' => now()->addDays(30)->format('m-d-Y'),
            'contract_number' => 'CN-123456',
            'contract_budget' => 10000,
            'contract_currency' => 'USD',
            'description' => 'This is a sample project description.',
            'comment' => 'Initial project setup.',
            'created_by' => 1,
            'status' => 'in_progress',
        ]);

        $file1 = UploadedFile::fake()->create('Маркетинг_стажер_требования.pdf', 1024, 'application/pdf');
        $file2 = UploadedFile::fake()->create('Описание_стажировки.docx', 1024, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $file3 = UploadedFile::fake()->create('Презентация_стажировки.pptx', 1024, 'application/vnd.openxmlformats-officedocument.presentationml.presentation');

        $savedPath1 = FileUploadHelper::file($file1, "projects/" . $project1->id);
        $project1->files()->create([
            'name' => $file1->getClientOriginalName(),
            'path' => $savedPath1['path'],
            'type' => 'document',
            'size' => $file1->getSize(),
        ]);

        $savedPath2 = FileUploadHelper::file($file2, "projects/" . $project1->id);
        $project1->files()->create([
            'name' => $file2->getClientOriginalName(),
            'path' => $savedPath2['path'],
            'type' => 'document',
            'size' => $file2->getSize(),
        ]);

        $savedPath3 = FileUploadHelper::file($file3, "projects/" . $project1->id);
        $project1->files()->create([
            'name' => $file3->getClientOriginalName(),
            'path' => $savedPath3['path'],
            'type' => 'presentation',
            'size' => $file3->getSize(),
        ]);

        $project2 = Project::create([
            'title' => 'Another Project',
            'client_id' => 2,
            'vacancy_id' => 2,
            'deadline' => now()->addDays(60)->format('m-d-Y'),
            'contract_number' => 'CN-654321',
            'contract_budget' => 20000,
            'contract_currency' => 'EUR',
            'description' => 'This is another sample project description.',
            'comment' => 'Project in the planning phase.',
            'created_by' => 1,
            'status' => 'in_progress',
        ]);

        $file1 = UploadedFile::fake()->create('Маркетинг_стажер_требования.pdf', 1024, 'application/pdf');
        $file2 = UploadedFile::fake()->create('Описание_стажировки.docx', 1024, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $file3 = UploadedFile::fake()->create('Презентация_стажировки.pptx', 1024, 'application/vnd.openxmlformats-officedocument.presentationml.presentation');

        $savedPath1 = FileUploadHelper::file($file1, "projects/" . $project2->id);
        $project2->files()->create([
            'name' => $file1->getClientOriginalName(),
            'path' => $savedPath1['path'],
            'type' => 'document',
            'size' => $file1->getSize(),
        ]);

        $savedPath2 = FileUploadHelper::file($file2, "projects/" . $project2->id);
        $project2->files()->create([
            'name' => $file2->getClientOriginalName(),
            'path' => $savedPath2['path'],
            'type' => 'document',
            'size' => $file2->getSize(),
        ]);

        $savedPath3 = FileUploadHelper::file($file3, "projects/" . $project2->id);
        $project2->files()->create([
            'name' => $file3->getClientOriginalName(),
            'path' => $savedPath3['path'],
            'type' => 'presentation',
            'size' => $file3->getSize(),
        ]);

        $project3 = Project::create([
            'title' => 'Cancelled Project',
            'client_id' => 2,
            'vacancy_id' => 3,
            'deadline' => now()->addDays(15)->format('m-d-Y'),
            'contract_number' => 'CN-789012',
            'contract_budget' => 5000,
            'contract_currency' => 'RUB',
            'description' => 'This project has been cancelled.',
            'comment' => 'Due to budget constraints.',
            'created_by' => 1,
            'status' => 'cancelled',
        ]);

        $file1 = UploadedFile::fake()->create('Маркетинг_стажер_требования.pdf', 1024, 'application/pdf');
        $file2 = UploadedFile::fake()->create('Описание_стажировки.docx', 1024, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $file3 = UploadedFile::fake()->create('Презентация_стажировки.pptx', 1024, 'application/vnd.openxmlformats-officedocument.presentationml.presentation');

        $savedPath1 = FileUploadHelper::file($file1, "projects/" . $project3->id);
        $project3->files()->create([
            'name' => $file1->getClientOriginalName(),
            'path' => $savedPath1['path'],
            'type' => 'document',
            'size' => $file1->getSize(),
        ]);

        $savedPath2 = FileUploadHelper::file($file2, "projects/" . $project3->id);
        $project3->files()->create([
            'name' => $file2->getClientOriginalName(),
            'path' => $savedPath2['path'],
            'type' => 'document',
            'size' => $file2->getSize(),
        ]);

        $savedPath3 = FileUploadHelper::file($file3, "projects/" . $project3->id);
        $project3->files()->create([
            'name' => $file3->getClientOriginalName(),
            'path' => $savedPath3['path'],
            'type' => 'presentation',
            'size' => $file3->getSize(),
        ]);
    }
}
