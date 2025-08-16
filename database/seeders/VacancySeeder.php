<?php

namespace Database\Seeders;

use App\Helpers\FileUploadHelper;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class VacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vacancy1 = Vacancy::create([
            'title' => 'Менеджер по продажам',
            'client_id' => 1,
            'department' => 'Отдел Продаж',
            'city' => 'Москва',
            'type_employment' => 'В офисе',
            'work_schedule' => 'Полный день',
            'work_experience' => '3-6 лет',
            'education' => 'Высшее',
            'status' => 'Открыта',
            'position_count' => 2,
            'created_by' => 1,
        ]);


        $file1 = UploadedFile::fake()->create('Требования_к_кандидатам.pdf', 1024, 'application/pdf');
        $file2 = UploadedFile::fake()->create('Описание_вакансии_менеджер.docx', 1024, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $file3 = UploadedFile::fake()->create('Презентация_компании.pptx', 1024, 'application/vnd.openxmlformats-officedocument.presentationml.presentation');

        $savedPath1 = FileUploadHelper::file($file1, "vacancies/" . $vacancy1->id);
        $vacancy1->files()->create([
            'name' => $file1->getClientOriginalName(),
            'path' => $savedPath1['path'],
            'type' => 'document',
            'size' => $file1->getSize(),
        ]);

        $savedPath2 = FileUploadHelper::file($file2, "vacancies/" . $vacancy1->id);
        $vacancy1->files()->create([
            'name' => $file2->getClientOriginalName(),
            'path' => $savedPath2['path'],
            'type' => 'document',
            'size' => $file2->getSize(),
        ]);

        $savedPath3 = FileUploadHelper::file($file3, "vacancies/" . $vacancy1->id);
        $vacancy1->files()->create([
            'name' => $file3->getClientOriginalName(),
            'path' => $savedPath3['path'],
            'type' => 'presentation',
            'size' => $file3->getSize(),
        ]);

        $vacancy2 = Vacancy::create([
            'title' => 'Разработчик PHP',
            'client_id' => 2,
            'department' => 'IT Отдел',
            'city' => 'Санкт-Петербург',
            'type_employment' => 'Удаленно',
            'work_schedule' => 'Удаленная работа',
            'work_experience' => '1-3 года',
            'education' => 'Неоконченное высшее',
            'status' => 'Не активна',
            'position_count' => 1,
            'created_by' => 1,
        ]);

        $file1 = UploadedFile::fake()->create('PHP_разработчик_требования.pdf', 1024, 'application/pdf');
        $file2 = UploadedFile::fake()->create('Описание_вакансии.docx', 1024, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $file3 = UploadedFile::fake()->create('PHP_Requirements.pptx', 1024, 'application/vnd.openxmlformats-officedocument.presentationml.presentation');

        $savedPath1 = FileUploadHelper::file($file1, "vacancies/" . $vacancy2->id);
        $vacancy2->files()->create([
            'name' => $file1->getClientOriginalName(),
            'path' => $savedPath1['path'],
            'type' => 'document',
            'size' => $file1->getSize(),
        ]);

        $savedPath2 = FileUploadHelper::file($file2, "vacancies/" . $vacancy2->id);
        $vacancy2->files()->create([
            'name' => $file2->getClientOriginalName(),
            'path' => $savedPath2['path'],
            'type' => 'document',
            'size' => $file2->getSize(),
        ]);

        $savedPath3 = FileUploadHelper::file($file3, "vacancies/" . $vacancy2->id);
        $vacancy2->files()->create([
            'name' => $file3->getClientOriginalName(),
            'path' => $savedPath3['path'],
            'type' => 'presentation',
            'size' => $file3->getSize(),
        ]);

        $vacancy3 = Vacancy::create([
            'title' => 'Стажер по маркетингу',
            'client_id' => 2,
            'department' => 'Маркетинг',
            'city' => 'Казань',
            'type_employment' => 'Стажировка',
            'work_schedule' => 'Гибкий график',
            'work_experience' => 'Без опыта',
            'education' => 'Среднее специальное',
            'status' => 'Закрыта',
            'position_count' => 5,
            'created_by' => 1,
        ]);

        $file1 = UploadedFile::fake()->create('Маркетинг_стажер_требования.pdf', 1024, 'application/pdf');
        $file2 = UploadedFile::fake()->create('Описание_стажировки.docx', 1024, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $file3 = UploadedFile::fake()->create('Презентация_стажировки.pptx', 1024, 'application/vnd.openxmlformats-officedocument.presentationml.presentation');

        $savedPath1 = FileUploadHelper::file($file1, "vacancies/" . $vacancy3->id);
        $vacancy3->files()->create([
            'name' => $file1->getClientOriginalName(),
            'path' => $savedPath1['path'],
            'type' => 'document',
            'size' => $file1->getSize(),
        ]);

        $savedPath2 = FileUploadHelper::file($file2, "vacancies/" . $vacancy3->id);
        $vacancy3->files()->create([
            'name' => $file2->getClientOriginalName(),
            'path' => $savedPath2['path'],
            'type' => 'document',
            'size' => $file2->getSize(),
        ]);

        $savedPath3 = FileUploadHelper::file($file3, "vacancies/" . $vacancy3->id);
        $vacancy3->files()->create([
            'name' => $file3->getClientOriginalName(),
            'path' => $savedPath3['path'],
            'type' => 'presentation',
            'size' => $file3->getSize(),
        ]);
    }
}
