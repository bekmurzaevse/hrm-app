<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $userIds = User::pluck('id');

        $projects->each(function ($project) use ($userIds) {
            $randomUserIds = $userIds->random(rand(1, 4))->all();

            $project->performers()->attach($randomUserIds);
        });

    }
}
