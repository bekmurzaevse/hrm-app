<?php

namespace Database\Seeders;

use App\Models\VacancyContact;
use Illuminate\Database\Seeder;

class VacancyContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VacancyContact::create([
            'vacancy_id' => 1,
            'name' => 'John Doe',
            'position' => 'Manager of Recruitment',
            'phone' => '+1234567890',
            'email' => 'johndoe@example.com',
        ]);


        VacancyContact::create([
            'vacancy_id' => 2,
            'name' => 'Jane Smith',
            'position' => 'HR Specialist',
            'phone' => '+0987654321',
            'email' => 'janesmith@example.com',
        ]);

        VacancyContact::create([
            'vacancy_id' => 3,
            'name' => 'Alice Johnson',
            'position' => 'Technical Recruiter',
            'phone' => '+1122334455',
            'email' => 'alicejohnson@example.com',
        ]);
    }
}
