<?php

namespace App\Http\Resources\v1\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'deadline' => $this->deadline->format('Y-m-d'),
            'deadline_human' => $this->deadline_human,
            'color' => $this->urgency_color,
            'created_by' => [
                'id' => $this->createdBy?->id,
                'name' => trim($this->createdBy?->first_name . ' ' . $this->createdBy?->last_name),
            ],
            'executors' => $this->taskUsers->map(fn($tu) => $tu->user->first_name . ' ' . $tu->user->last_name),
            'status' => $this->status,
            'priority' => $this->priority,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i'),
        ];
    }
}