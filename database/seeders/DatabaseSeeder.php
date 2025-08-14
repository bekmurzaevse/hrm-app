<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            CandidateSeeder::class,
            LanguageSeeder::class,
            SkillSeeder::class,
            ContactSeeder::class,
            TypeSeeder::class,
            InteractionSeeder::class,
            EducationSeeder::class,
            WorkExperienceSeeder::class,
            ClientSeeder::class,
            ContactPersonSeeder::class,
            VacancySeeder::class,
            VacancyContactSeeder::class,
            AddSeeder::class,
            CandidateAssignmentSeeder::class,
            TagSeeder::class,
            VacancyDetailSeeder::class,
            VacancySalarySeeder::class,
        ]);
    }
}
