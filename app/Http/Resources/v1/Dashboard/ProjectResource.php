<?php

namespace App\Http\Resources\v1\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'client_name' => $this->client?->name,
            'vacancy_title' => $this->vacancy?->title,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d'),
            'deadline' => $this->deadline->format('Y-m-d'),
            'performers' => $this->performers_fio,
            'comment' => $this->comment,
        ];
    }
}
