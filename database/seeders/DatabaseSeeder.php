<?php

namespace Database\Seeders;

use App\Models\SelectionItems;
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
            TaskSeeder::class,
            FinanceSeeder::class,
            SelectionSeeder::class,
            SelectionItemSeeder::class
        ]);
    }
}
