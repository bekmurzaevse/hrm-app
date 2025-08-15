<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Vacancy;
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

        $vacancy = Vacancy::find(1);
        $vacancy->skills()->createMany([
            ['title' => 'Продажи'],
            ['title' => 'CRM'],
            ['title' => 'Переговоры'],
            ['title' => 'B2B'],
        ]);

        $vacancy = Vacancy::find(2);
        $vacancy->skills()->createMany([
            ['title' => 'PHP'],
            ['title' => 'Laravel'],
            ['title' => 'MySQL'],
            ['title' => 'Docker'],
        ]);

        $vacancy = Vacancy::find(3);
        $vacancy->skills()->createMany([
            ['title' => 'Продажи'],
            ['title' => 'CRM'],
            ['title' => 'Маркетинг'],
            ['title' => 'Аналитика'],
        ]);
    }
}
