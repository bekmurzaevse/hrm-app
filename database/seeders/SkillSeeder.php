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
        Skill::create([
            'title' => 'Переговоры',
            'candidate_id' => Candidate::inRandomOrder()->first()->id,
            'description' => 'description',
        ]);

        Skill::create([
            'title' => 'CRM',
            'candidate_id' => Candidate::inRandomOrder()->first()->id,
            'description' => 'description',
        ]);
    }
}
