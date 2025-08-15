<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Candidate::inRandomOrder()->first()->skills()->create([
            'title' => 'CRM',
        ]);
        Candidate::inRandomOrder()->first()->skills()->create([
            'title' => 'B2B',
        ]);
    }
}
