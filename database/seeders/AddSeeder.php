<?php

namespace Database\Seeders;

use App\Models\Add;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Add::create([
            'addable_type' => 'App\\Models\\Vacancy',
            'addable_id' => 1,
            'source' => 'HeadHunter',
            'status' => 'Неактивна',
            'period_start' => now()->toDateString(),
            'period_end' => now()->addDays(30)->toDateString(),
            'budget' => 1000,
            'currency' => 'USD',
            'views_count' => 420,
            'response_count' => 40,
            'created_by' => 1,
        ]);

        Add::create([
            'addable_type' => 'App\\Models\\Vacancy',
            'addable_id' => 1,
            'source' => 'SuperJob',
            'status' => 'Активна',
            'period_start' => now()->addDays(10)->toDateString(),
            'period_end' => now()->addDays(30)->toDateString(),
            'budget' => 1000,
            'currency' => 'USD',
            'views_count' => 1230,
            'response_count' => 234,
            'created_by' => 1,
        ]);


        Add::create([
            'addable_type' => 'App\\Models\\Vacancy',
            'addable_id' => 2,
            'source' => 'HeadHunter',
            'status' => 'Активна',
            'period_start' => now()->toDateString(),
            'period_end' => now()->addDays(20)->toDateString(),
            'budget' => 1200,
            'currency' => 'USD',
            'views_count' => 420,
            'response_count' => 40,
            'created_by' => 1,
        ]);

        Add::create([
            'addable_type' => 'App\\Models\\Vacancy',
            'addable_id' => 2,
            'source' => 'SuperJob',
            'status' => 'Неактивна',
            'period_start' => now()->addDays(15)->toDateString(),
            'period_end' => now()->addDays(35)->toDateString(),
            'budget' => 1300,
            'currency' => 'USD',
            'views_count' => 120,
            'response_count' => 34,
            'created_by' => 1,
        ]);


        Add::create([
            'addable_type' => 'App\\Models\\Vacancy',
            'addable_id' => 3,
            'source' => 'HeadHunter',
            'status' => 'Активна',
            'period_start' => now()->toDateString(),
            'period_end' => now()->addDays(10)->toDateString(),
            'budget' => 900,
            'currency' => 'USD',
            'views_count' => 1300,
            'response_count' => 400,
            'created_by' => 1,
        ]);

        Add::create([
            'addable_type' => 'App\\Models\\Vacancy',
            'addable_id' => 3,
            'source' => 'SuperJob',
            'status' => 'Активна',
            'period_start' => now()->addDays(5)->toDateString(),
            'period_end' => now()->addDays(20)->toDateString(),
            'budget' => 600,
            'currency' => 'USD',
            'views_count' => 500,
            'response_count' => 242,
            'created_by' => 1,
        ]);
    }
}
