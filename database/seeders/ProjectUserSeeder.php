<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $userCount = $userIds->count();

        $projects->each(function ($project) use ($userIds, $userCount) {
            $randomUserIds = $userIds->random(rand(1, $userCount))->all();

            $project->performers()->attach($randomUserIds);
        });

    }
}
