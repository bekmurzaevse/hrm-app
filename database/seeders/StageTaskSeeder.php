<?php

namespace Database\Seeders;

use App\Models\StageTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StageTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StageTask::create([
            'stage_id' => 1,
            'title' => 'Sample Task',
            'description' => 'This is a sample task description.',
            'excutor_id' => 1,
            'priority' => 'medium',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'created_by' => 1,
        ]);

        StageTask::create([
            'stage_id' => 1,
            'title' => 'Another Task',
            'description' => 'This is another task description.',
            'excutor_id' => 2,
            'priority' => 'high',
            'deadline' => now()->addDays(5)->format('Y-m-d'),
            'created_by' => 1,
        ]);

        StageTask::create([
            'stage_id' => 2,
            'title' => 'Third Task',
            'description' => 'This is the third task description.',
            'excutor_id' => 1,
            'priority' => 'low',
            'deadline' => now()->addDays(10)->format('Y-m-d'),
            'created_by' => 1,
        ]);

        StageTask::create([
            'stage_id' => 2,
            'title' => 'Fourth Task',
            'description' => 'This is the fourth task description.',
            'excutor_id' => 2,
            'priority' => 'medium',
            'deadline' => now()->addDays(3)->format('Y-m-d'),
            'created_by' => 1,
        ]);

        StageTask::create([
            'stage_id' => 6,
            'title' => 'Sample Task',
            'description' => 'This is a sample task description.',
            'excutor_id' => 1,
            'priority' => 'medium',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'created_by' => 1,
        ]);

        StageTask::create([
            'stage_id' => 6,
            'title' => 'Another Task',
            'description' => 'This is another task description.',
            'excutor_id' => 2,
            'priority' => 'high',
            'deadline' => now()->addDays(5)->format('Y-m-d'),
            'created_by' => 1,
        ]);

        StageTask::create([
            'stage_id' => 7,
            'title' => 'Third Task',
            'description' => 'This is the third task description.',
            'excutor_id' => 1,
            'priority' => 'low',
            'deadline' => now()->addDays(10)->format('Y-m-d'),
            'created_by' => 1,
        ]);

        StageTask::create([
            'stage_id' => 7,
            'title' => 'Fourth Task',
            'description' => 'This is the fourth task description.',
            'excutor_id' => 2,
            'priority' => 'medium',
            'deadline' => now()->addDays(3)->format('Y-m-d'),
            'created_by' => 1,
        ]);

        StageTask::create([
            'stage_id' => 10,
            'title' => 'Sample Task',
            'description' => 'This is a sample task description.',
            'excutor_id' => 1,
            'priority' => 'medium',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'created_by' => 1,
        ]);

        StageTask::create([
            'stage_id' => 10,
            'title' => 'Another Task',
            'description' => 'This is another task description.',
            'excutor_id' => 2,
            'priority' => 'high',
            'deadline' => now()->addDays(5)->format('Y-m-d'),
            'created_by' => 1,
        ]);

        StageTask::create([
            'stage_id' => 11,
            'title' => 'Third Task',
            'description' => 'This is the third task description.',
            'excutor_id' => 1,
            'priority' => 'low',
            'deadline' => now()->addDays(10)->format('Y-m-d'),
            'created_by' => 1,
        ]);

        StageTask::create([
            'stage_id' => 11,
            'title' => 'Fourth Task',
            'description' => 'This is the fourth task description.',
            'excutor_id' => 2,
            'priority' => 'medium',
            'deadline' => now()->addDays(3)->format('Y-m-d'),
            'created_by' => 1,
        ]);
    }
}
