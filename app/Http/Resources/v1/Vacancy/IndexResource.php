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
            'client_name' => $this->client?->name,
            'salary' => $this->salary,
            'region' => $this->district?->region?->title,
            'district' => $this->district?->title,
            'created_by' => $this->createdBy?->shortFio,
            'created_at' => $this->created_at?->format('Y-m-d'),
            'status' => $this->status,
        ];
    }
}
