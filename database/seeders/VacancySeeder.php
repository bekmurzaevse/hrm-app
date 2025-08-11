<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vacancy::create([
            'title' => 'Laravel developer',
            'client_id' => Client::inRandomOrder()->first()->id,
            'salary' => 6000000,
            // 'salary_period' => '',
            'city' => 'Nukus',
            'user_id' => User::inRandomOrder()->first()->id,
            // 'status' => '',
            // 'type_employment' => '',
            // 'temporary_from' => '',
            // 'temporary_to' => '',
            // 'KPI' => '',
            // 'probation_period' => '',
            // 'probation_salary' => '',
            'employee_count' => 5,
            // 'description' => '',
        ]);

        Vacancy::create([
            'title' => 'React developer',
            'client_id' => Client::inRandomOrder()->first()->id,
            'salary' => 5000000,
            // 'salary_period' => '',
            'city' => 'Nukus',
            'user_id' => User::inRandomOrder()->first()->id,
            // 'status' => '',
            // 'type_employment' => '',
            // 'temporary_from' => '',
            // 'temporary_to' => '',
            // 'KPI' => '',
            // 'probation_period' => '',
            // 'probation_salary' => '',
            'employee_count' => 1,
            // 'description' => '',
        ]);
    }
}
