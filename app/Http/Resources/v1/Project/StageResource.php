<?php

namespace App\Http\Resources\v1\Project;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline,
            'executor_fio' => $this->executor->shortFio,
            'order' => $this->order,
            'is_required' => $this->is_required,
            'status' => $this->status,
            'task_count' => $this->stageTasks->count(),
            'tasks' => $this->stageTasks->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'executor' => $task->executor?->shortFio,
                    'priority' => $task->priority,
                    'deadline' => $task->deadline,
                ];
            }),
        ];
    }
}
