<?php

namespace Database\Seeders;

use App\Models\Stage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stage::create([
            'title' => 'Первичный отбор',
            'description' => 'Анализ резюме и первичная оценка кандидатов',
            'deadline' => now()->addDays(2)->format('Y-m-d'),
            'is_required' => true,
            'created_by' => 1,
            'order' => 1,
            'status' => 'completed',
            'project_id' => 1,
            'executor_id' => 1,
        ]);


        Stage::create([
            'title' => 'Собеседования',
            'description' => 'Проведение интервью с отобранными кандидатами',
            'deadline' => now()->addDays(3)->format('Y-m-d'),
            'is_required' => false,
            'created_by' => 1,
            'order' => 2,
            'status' => 'in_progress',
            'project_id' => 1,
            'executor_id' => 1,
        ]);


        Stage::create([
            'title' => 'Выход на работу',
            'description' => 'Оформление и адаптация новых сотрудников',
            'deadline' => now()->addDays(4)->format('Y-m-d'),
            'is_required' => true,
            'created_by' => 1,
            'order' => 3,
            'status' => 'waiting',
            'project_id' => 1,
            'executor_id' => 1,
        ]);


        Stage::create([
            'title' => 'Оплата контракта',
            'description' => 'Получение оплаты от клиента',
            'deadline' => now()->addDays(5)->format('Y-m-d'),
            'is_required' => true,
            'created_by' => 1,
            'order' => 4,
            'status' => 'waiting',
            'project_id' => 1,
            'executor_id' => 1,
        ]);

        Stage::create([
            'title' => 'Закрытие проекта',
            'description' => 'Финальная отчетность и закрытие',
            'deadline' => now()->addDays(6)->format('Y-m-d'),
            'is_required' => false,
            'created_by' => 1,
            'order' => 5,
            'status' => 'waiting',
            'project_id' => 1,
            'executor_id' => 1,
        ]);


        Stage::create([
            'title' => 'Первичный отбор',
            'description' => 'Анализ резюме и первичная оценка кандидатов',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'is_required' => false,
            'created_by' => 1,
            'order' => 1,
            'status' => 'completed',
            'project_id' => 2,
            'executor_id' => 1,
        ]);

        Stage::create([
            'title' => 'Выход на работу',
            'description' => 'Оформление и адаптация новых сотрудников',
            'deadline' => now()->addDays(10)->format('Y-m-d'),
            'is_required' => true,
            'created_by' => 1,
            'order' => 2,
            'status' => 'in_progress',
            'project_id' => 2,
            'executor_id' => 1,
        ]);


        Stage::create([
            'title' => 'Оплата контракта',
            'description' => 'Получение оплаты от клиента',
            'deadline' => now()->addDays(11)->format('Y-m-d'),
            'is_required' => true,
            'created_by' => 1,
            'order' => 3,
            'status' => 'waiting',
            'project_id' => 2,
            'executor_id' => 1,
        ]);

        Stage::create([
            'title' => 'Закрытие проекта',
            'description' => 'Финальная отчетность и закрытие',
            'deadline' => now()->addDays(12)->format('Y-m-d'),
            'is_required' => true,
            'created_by' => 1,
            'order' => 4,
            'status' => 'waiting',
            'project_id' => 2,
            'executor_id' => 1,
        ]);


        Stage::create([
            'title' => 'Первичный отбор',
            'description' => 'Анализ резюме и первичная оценка кандидатов',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'is_required' => true,
            'created_by' => 1,
            'order' => 1,
            'status' => 'completed',
            'project_id' => 3,
            'executor_id' => 1,
        ]);

        Stage::create([
            'title' => 'Выход на работу',
            'description' => 'Оформление и адаптация новых сотрудников',
            'deadline' => now()->addDays(8)->format('Y-m-d'),
            'is_required' => true,
            'created_by' => 1,
            'order' => 2,
            'status' => 'in_progress',
            'project_id' => 3,
            'executor_id' => 1,
        ]);


        Stage::create([
            'title' => 'Оплата контракта',
            'description' => 'Получение оплаты от клиента',
            'deadline' => now()->addDays(9)->format('Y-m-d'),
            'is_required' => true,
            'created_by' => 1,
            'order' => 3,
            'status' => 'waiting',
            'project_id' => 3,
            'executor_id' => 1,
        ]);

        Stage::create([
            'title' => 'Закрытие проекта',
            'description' => 'Финальная отчетность и закрытие',
            'deadline' => now()->addDays(10)->format('Y-m-d'),
            'is_required' => true,
            'created_by' => 1,
            'order' => 4,
            'status' => 'waiting',
            'project_id' => 3,
            'executor_id' => 1,
        ]);
    }
}
