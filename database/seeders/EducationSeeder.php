<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Education;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Education::create([
            'title' => 'Nukus State Pedagogical Insitute',
            'degree' => 'Bachelor',
            'specialty' => 'Informatics',
            'start_year' => '2015',
            'end_year' => '2019',
            'candidate_id' => Candidate::inRandomOrder()->first()->id,
            'description' => 'Education description',
        ]);

        Education::create([
            'title' => 'Karakalpak State University',
            'degree' => 'Bachelor',
            'specialty' => 'Matemathics',
            'start_year' => '2010',
            'end_year' => '2014',
            'candidate_id' => Candidate::inRandomOrder()->first()->id,
            'description' => 'Education description',
        ]);
    }
}
