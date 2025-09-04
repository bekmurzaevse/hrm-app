<?php

namespace Database\Seeders;

use App\Models\Candidate\Task\TaskPriorityEnum;
use App\Models\Candidate\Task\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::create([
            'title' => 'HeadHunter ga vakansiya qoyiw',
            'description' => "HR menejer ushin vakansiya jaratiw ha'm dag'aza qiliw",
            'deadline' => now()->addDays(5)->format('m-d-Y'),
            'created_by' => 1, 
            'status' => TaskStatusEnum::OPEN->value,
            'priority' => TaskPriorityEnum::MEDIUM->value,
        ]);

        Task::create([
            'title' => "Jumisshilar dizimini jan'alaw",
            'description' => "Mag'liwmatlar bazasindag'i barliq jumisshilardi qayta tekseriw",
            'deadline' => now()->addDays(10)->format('m-d-Y'),
            'created_by' => 1,
            'status' => TaskStatusEnum::IN_PROGRESS->value,
            'priority' => TaskPriorityEnum::HIGH->value,
        ]);
    }
}
