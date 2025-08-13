<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Candidate::inRandomOrder()->first()->skills()->create([
            'title' => 'English',
            'type' => 'language',
            'description' => 'test',
        ]);
        Candidate::inRandomOrder()->first()->skills()->create([
            'title' => 'Russian',
            'type' => 'language',
            'description' => 'test',
        ]);
    }
}
