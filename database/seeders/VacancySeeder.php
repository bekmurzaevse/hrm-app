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
            'salary' => "60000-80000",
            'currency' => 'USD',
            'period' => 'В месяц',
            'bonus' => 'Performance-based bonuses available.',
            'probation' => '6 months',
            'probation_salary' => 55000,
            'description' => 'Develop and maintain web applications.',
            'requirements' => 'Bachelor\'s degree in Computer Science or related field. Experience with PHP and Laravel.',
            'responsibilities' => 'Write clean, scalable code. Collaborate with front-end developers and other team members.',
            'work_conditions' => 'Full-time position. Remote work available.',
            'benefits' => 'Health insurance, paid time off, and professional development opportunities.',
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
            'salary' => "70000-80000",
            'currency' => 'RUB',
            'period' => 'В неделю',
            'bonus' => 'Annual performance bonus based on company profits.',
            'probation' => '3 months',
            'probation_salary' => 65000,
            'description' => 'Manage and oversee the company\'s financial operations.',
            'requirements' => 'Bachelor\'s degree in Finance or Accounting. CPA preferred.',
            'responsibilities' => 'Prepare financial reports, budgets, and forecasts. Ensure compliance with financial regulations.',
            'work_conditions' => 'Full-time position. Office-based with occasional remote work.',
            'benefits' => 'Competitive salary, retirement plan, and health benefits.',
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
            'salary' => "50000",
            'currency' => 'EUR',
            'period' => 'В месяц',
            'bonus' => 'Quarterly bonuses based on team performance.',
            'probation' => '3 months',
            'probation_salary' => 45000,
            'description' => 'Lead the marketing team to develop and implement marketing strategies.',
            'requirements' => 'Bachelor\'s degree in Marketing or Business. Proven experience in a marketing role.',
            'responsibilities' => 'Conduct market research, manage campaigns, and analyze performance metrics.',
            'work_conditions' => 'Full-time position. Hybrid work model available.',
            'benefits' => 'Flexible working hours, health insurance, and professional growth opportunities.',
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
