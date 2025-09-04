<?php

namespace Database\Seeders;

use App\Models\Candidate\Task\TaskStatusEnum;
use App\Models\TaskUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaskUser::create([
            'task_id' => 1,
            'user_id' => 2,
            'assigned_at' => now(),
            'status' => TaskStatusEnum::OPEN->value,
        ]);

        TaskUser::create([
            'task_id' => 1,
            'user_id' => 3,
            'assigned_at' => now(),
            'status' => TaskStatusEnum::OPEN->value,
        ]);

        TaskUser::create([
            'task_id' => 2,
            'user_id' => 4,
            'assigned_at' => now(),
            'status' => TaskStatusEnum::OPEN->value,
        ]);
    }
}
