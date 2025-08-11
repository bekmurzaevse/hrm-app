<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::create([
            'title' => 'English',
            'degree' => 'B2',
            'candidate_id' => Candidate::inRandomOrder()->first()->id,
            'description' => 'description',
        ]);

        Language::create([
            'title' => 'Russian',
            'degree' => 'B1',
            'candidate_id' => Candidate::inRandomOrder()->first()->id,
            'description' => 'description',
        ]);
    }
}
