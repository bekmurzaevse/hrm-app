<?php

namespace Database\Seeders;

use App\Models\TaskHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaskHistory::create([
            'task_id' => 1,
            'type' => 'task_completed',
            'changed_by' => 1,
            'comment' => 'Задача завершена',
        ]);

        TaskHistory::create([
            'task_id' => 2,
            'type' => 'executor_added',
            'changed_by' => 2,
            'comment' => 'Исполнитель добавлен',
        ]);

        TaskHistory::create([
            'task_id' => 1,
            'type' => 'executor_removed',
            'changed_by' => 3,
            'comment' => 'Исполнитель удален',
        ]);
    }
}
