<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\WorkExperience;
use Illuminate\Database\Seeder;

class WorkExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkExperience::create([
            'company' => 'Google',
            'position' => 'Backend developer',
            'start_work' => '2020',
            'end_work' => '2024',
            'candidate_id' => Candidate::inRandomOrder()->first()->id,
            'description' => 'Work experience description',
        ]);
        
        WorkExperience::create([
            'company' => 'Microsoft',
            'position' => 'CTO',
            'start_work' => '2024',
            // 'end_work' => '',
            'candidate_id' => Candidate::inRandomOrder()->first()->id,
            'description' => 'Work experience description',
        ]);
    }
}
