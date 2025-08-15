<?php

namespace Database\Seeders;

use App\Models\Vacancy;
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
            'position_count' => 2,
            'created_by' => 1,
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
            'status' => 'Не активна',
            'position_count' => 1,
            'created_by' => 1,
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
            'status' => 'Закрыта',
            'position_count' => 5,
            'created_by' => 1,
        ]);
    }
}
