<?php

namespace App\Http\Resources\v1\Vacancy;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
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
            'position_count' => $this->position_count,
            'client_name' => $this->client->name,
            'salary' => $this->salary,
            'city' => $this?->city,
            'created_by' => $this->creator,
            'created_at' => $this->created_at->format('Y-m-d'),
            'status' => $this->status,
        ];
    }
}
