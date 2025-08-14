<?php

namespace Database\Seeders;

use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vacancy::create([
            'title' => 'Менеджер по продажам',
            'client_id' => 1,
            'department' => 'Отдел Продаж',
            'city' => 'Москва',
            'type_employment' => 'В офисе',
            'work_schedule' => 'Полный день',
            'work_experience' => '3-6 лет',
            'education' => 'Высшее',
            'status' => 'Открыта',
            'priority' => 'Высокий',
            'deadline' => Carbon::now()->addDays(30)->format('m-d-Y'),
            'manager_id' => 1,
            'recruiter_id' => 1,
            'created_by' => 1,
            'comment' => 'Требуется опыт работы в продажах не менее 3 лет.',
            'position_count' => 2,
        ]);

        Vacancy::create([
            'title' => 'Разработчик PHP',
            'client_id' => 2,
            'department' => 'IT Отдел',
            'city' => 'Санкт-Петербург',
            'type_employment' => 'Удаленно',
            'work_schedule' => 'Удаленная работа',
            'work_experience' => '1-3 года',
            'education' => 'Неоконченное высшее',
            'status' => 'В работе',
            'priority' => 'Средний',
            'deadline' => Carbon::now()->addDays(60)->format('m-d-Y'),
            'manager_id' => 1,
            'recruiter_id' => 1,
            'created_by' => 1,
            'comment' => 'Ищем разработчика с опытом работы с Laravel.',
            'position_count' => 1,
        ]);

        Vacancy::create([
            'title' => 'Стажер по маркетингу',
            'client_id' => 2,
            'department' => 'Маркетинг',
            'city' => 'Казань',
            'type_employment' => 'Стажировка',
            'work_schedule' => 'Гибкий график',
            'work_experience' => 'Без опыта',
            'education' => 'Среднее специальное',
            'status' => 'Открыта',
            'priority' => 'Низкий',
            'deadline' => Carbon::now()->addDays(90)->format('m-d-Y'),
            'manager_id' => 1,
            'recruiter_id' => 1,
            'created_by' => 1,
            'comment' => 'Ищем активного и креативного стажера для работы в команде маркетинга.',
            'position_count' => 5,
        ]);
    }
}
