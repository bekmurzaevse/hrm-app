<?php

namespace Database\Seeders;

use App\Enums\CurrencyEnum;
use App\Enums\EducationEnum;
use App\Enums\EmploymentTypeEnum;
use App\Enums\PeriodEnum;
use App\Enums\VacancyStatusEnum;
use App\Enums\WorkExperienceEnum;
use App\Enums\WorkScheduleEnum;
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
            'type_employment' => EmploymentTypeEnum::OFFICE->value,
            'work_schedule' => WorkScheduleEnum::FULL_TIME->value,
            'work_experience' => WorkExperienceEnum::THREE_TO_SIX->value,
            'education' => EducationEnum::HIGHER->value,
            'status' => VacancyStatusEnum::OPEN->value,
            'position_count' => 2,
            'created_by' => 1,
            'salary' => "60000-80000",
            'currency' => CurrencyEnum::RUB->value,
            'period' => PeriodEnum::MONTH->value,
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
            'type_employment' => EmploymentTypeEnum::REMOTE->value,
            'work_schedule' => WorkScheduleEnum::REMOTE->value,
            'work_experience' => WorkExperienceEnum::ONE_TO_THREE->value,
            'education' => EducationEnum::INCOMPLETE_HIGHER->value,
            'status' => VacancyStatusEnum::NOT_ACTIVE->value,
            'position_count' => 1,
            'created_by' => 1,
            'salary' => "70000-80000",
            'currency' => CurrencyEnum::RUB->value,
            'period' => PeriodEnum::WEEK->value,
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
            'type_employment' => EmploymentTypeEnum::INTERNSHIP->value,
            'work_schedule' => WorkScheduleEnum::FLEXIBLE->value,
            'work_experience' => WorkExperienceEnum::NO_EXPERIENCE->value,
            'education' => EducationEnum::SECONDARY_VOCATIONAL->value,
            'status' => VacancyStatusEnum::CLOSED->value,
            'position_count' => 5,
            'created_by' => 1,
            'salary' => "50000",
            'currency' => CurrencyEnum::EUR->value,
            'period' => PeriodEnum::MONTH->value,
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
