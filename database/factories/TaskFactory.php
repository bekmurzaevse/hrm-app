<?php 

namespace Database\Factories;

use App\Enums\Task\TaskPriorityEnum;
use App\Enums\Task\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'deadline' => now()->addDays(3),
            'status' => TaskStatusEnum::OPEN,
            'priority' => TaskPriorityEnum::MEDIUM,
            'created_by' => 1,
            'comment' => $this->faker->sentence,
        ];
    }
}