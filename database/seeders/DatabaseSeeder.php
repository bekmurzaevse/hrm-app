<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserPermissionSeeder::class,
            UserSeeder::class,
            RegionSeeder::class,
            DistrictSeeder::class,
            CandidateSeeder::class,
            LanguageSeeder::class,
            TypeSeeder::class,
            ClientSeeder::class,
            VacancySeeder::class,
            SkillSeeder::class,
            ContactSeeder::class,
            TypeSeeder::class,
            InteractionSeeder::class,
            EducationSeeder::class,
            WorkExperienceSeeder::class,
            TagSeeder::class,
            ProjectSeeder::class,
            StageSeeder::class,
            StageCompletionSeeder::class,
            StageTaskSeeder::class,
            ProjectUserSeeder::class,
            FinanceSeeder::class,
            SelectionSeeder::class,
            SelectionItemSeeder::class,
            TaskSeeder::class,
            TaskUserSeeder::class,
            FinanceSeeder::class,
            SelectionStatusSeeder::class,
            StatusValueSeeder::class
        ]);
    }
}
