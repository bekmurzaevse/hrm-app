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
            UserPermissionSeeder::class,
            UserSeeder::class,
            CandidateSeeder::class,
            LanguageSeeder::class,
            ClientSeeder::class,
            VacancySeeder::class,
            SkillSeeder::class,
            ContactSeeder::class,
            TypeSeeder::class,
            InteractionSeeder::class,
            EducationSeeder::class,
            WorkExperienceSeeder::class,
            ContactPersonSeeder::class,
            TagSeeder::class,
            ProjectSeeder::class,
            StageSeeder::class,
            StageCompletionSeeder::class,
            StageTaskSeeder::class,
            ProjectUserSeeder::class
        ]);
    }
}
