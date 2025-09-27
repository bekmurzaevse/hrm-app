<?php

namespace Database\Seeders;

use App\Enums\Task\TaskStatusEnum;
use App\Models\TaskUser;
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
            'user_id' => 1,
            'accepted_at' => now(),
            'status' => TaskStatusEnum::IN_PROGRESS->value,
        ]);

        TaskUser::create([
            'task_id' => 1,
            'user_id' => 3,
            'status' => TaskStatusEnum::OPEN->value,
        ]);

        TaskUser::create([
            'task_id' => 2,
            'user_id' => 5,
            'status' => TaskStatusEnum::OPEN->value,
        ]);
    }
}
