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

        Vacancy::find(1)->skills()->createMany([
            [
                'title' => 'Продажи',
                'description' => 'test',
            ],
            [
                'title' => 'CRM',
                'description' => 'test',
            ],
            [
                'title' => 'Переговоры',
                'description' => 'test',
            ],
            [
                'title' => 'B2B',
                'description' => 'test',
            ],
        ]);

        Vacancy::find(2)->skills()->createMany([
            [
                'title' => 'PHP',
                'description' => 'test',
            ],
            [
                'title' => 'Laravel',
                'description' => 'test',
            ],
            [
                'title' => 'MySQL',
                'description' => 'test',
            ],
            [
                'title' => 'Docker',
                'description' => 'test',
            ],
        ]);

        Vacancy::find(3)->skills()->createMany([
            [
                'title' => 'Продажи',
                'description' => 'test',
            ],
            [
                'title' => 'CRM',
                'description' => 'test',
            ],
            [
                'title' => 'Маркетинг',
                'description' => 'test',
            ],
            [
                'title' => 'Аналитика',
                'description' => 'test',
            ],
        ]);

    }
}
