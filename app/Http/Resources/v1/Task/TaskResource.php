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
            'deadline' => $this->deadline,
            'created_by'  => [
                'id'   => $this->creator?->id,
                'name' => $this->creator?->name,
            ],
            'status' => $this->status,
            'priority' => $this->priority,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at,
        ];
    }
}