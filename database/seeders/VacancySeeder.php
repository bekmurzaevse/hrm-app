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
            'client_id' => 1,
            'title' => 'Temporary Project Assistant',
            'description' => 'Temporary position, 3-5 years of experience.',
            'city' => 'Samarkand',
            'type_employment' => 'temporary',
            'status' => 'in_active',
            'experience_min' => 3,
            'experience_max' => 5,
            'salary_min' => 50000.00,
            'salary_max' => 70000.00,
            'salary_period' => 'week',
            'probation_period_value' => 1,
            'probation_period_unit' => 'month',
            'probation_salary_amount' => 45000.00,
            'probation_salary_period' => 'week',
            'temporary_from' => Carbon::now()->toDateString(),
            'temporary_to' => Carbon::now()->addMonths(1)->toDateString(),
            'created_by' => 1,
            'employee_count' => 2,
        ]);


        Vacancy::create([
            'client_id' => 1,
            'title' => 'Intern Frontend Developer',
            'description' => 'Internship, no prior experience required.',
            'city' => 'Tashkent',
            'type_employment' => 'internship',
            'status' => 'not_closed',
            'experience_min' => 0,
            'experience_max' => 0,
            'salary_min' => 30000.00,
            'salary_max' => 40000.00,
            'salary_period' => 'month',
            'probation_period_value' => null,
            'probation_period_unit' => null,
            'probation_salary_amount' => null,
            'probation_salary_period' => null,
            'temporary_from' => null,
            'temporary_to' => null,
            'created_by' => 1,
            'employee_count' => 1,
        ]);

        Vacancy::create([
            'client_id' => 1,
            'title' => 'Backend Developer (Remote)',
            'description' => 'Remote position, 5+ years experience.',
            'city' => 'Tashkent',
            'type_employment' => 'remote',
            'status' => 'closed',
            'experience_min' => 5,
            'experience_max' => null,
            'salary_min' => 80000.00,
            'salary_max' => 100000.00,
            'salary_period' => 'month',
            'probation_period_value' => 2,
            'probation_period_unit' => 'months',
            'probation_salary_amount' => 120000.00,
            'probation_salary_period' => 'month',
            'temporary_from' => null,
            'temporary_to' => null,
            'created_by' => 1,
            'employee_count' => 3,
        ]);

        Vacancy::create([
            'client_id' => 1,
            'title' => 'Office HR Specialist',
            'description' => 'Office work, no experience required.',
            'city' => 'Bukhara',
            'type_employment' => 'office',
            'status' => 'open',
            'experience_min' => 2,
            'experience_max' => null,
            'salary_min' => 45000.00,
            'salary_max' => 60000.00,
            'salary_period' => 'month',
            'probation_period_value' => 15,
            'probation_period_unit' => 'days',
            'probation_salary_amount' => 40000.00,
            'probation_salary_period' => 'month',
            'temporary_from' => null,
            'temporary_to' => null,
            'created_by' => 1,
            'employee_count' => 5,
        ]);
    }
}
