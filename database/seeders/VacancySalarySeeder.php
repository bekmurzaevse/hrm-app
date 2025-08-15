<?php

namespace Database\Seeders;

use App\Models\VacancySalary;
use Illuminate\Database\Seeder;

class VacancySalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VacancySalary::create([
            'vacancy_id' => 1,
            'salary_from' => 60000,
            'salary_to' => 80000,
            'currency' => 'USD',
            'period' => 'month',
            'bonus' => 'Performance-based bonuses available.',
            'probation' => '6 months',
            'probation_salary' => 55000,
        ]);


        VacancySalary::create([
            'vacancy_id' => 2,
            'salary_from' => 70000,
            'salary_to' => 90000,
            'currency' => 'RUB',
            'period' => 'week',
            'bonus' => 'Annual performance bonus based on company profits.',
            'probation' => '3 months',
            'probation_salary' => 65000,
        ]);

        VacancySalary::create([
            'vacancy_id' => 3,
            'salary_from' => 50000,
            'salary_to' => 0,
            'currency' => 'EUR',
            'period' => 'month',
            'bonus' => 'Quarterly bonuses based on team performance.',
            'probation' => '3 months',
            'probation_salary' => 45000,
        ]);
    }
}
