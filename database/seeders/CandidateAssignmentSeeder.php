<?php

namespace Database\Seeders;

use App\Models\CandidateAssignment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CandidateAssignment::create([
            'candidate_id' => 1,
            'status' => 'Отобран',
            'assignable_type' => 'App\\Models\\Vacancy',
            'assignable_id' => 1,
        ]);

        CandidateAssignment::create([
            'candidate_id' => 2,
            'status' => 'На рассмотрении',
            'assignable_type' => 'App\\Models\\Vacancy',
            'assignable_id' => 1,
        ]);

        CandidateAssignment::create([
            'candidate_id' => 1,
            'status' => 'На рассмотрении',
            'assignable_type' => 'App\\Models\\Vacancy',
            'assignable_id' => 3,
        ]);

        CandidateAssignment::create([
            'candidate_id' => 2,
            'status' => 'Отклонен',
            'assignable_type' => 'App\\Models\\Vacancy',
            'assignable_id' => 3,
        ]);
    }
}
