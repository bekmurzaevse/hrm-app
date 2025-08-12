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
            'name' => [
                'title' => $this->title,
                'count' => $this->employee_count,
                'type' => $this->type_employment,
                'experience' => $this->experience,
            ],
            'client' => $this->client->name,
            'salary' => $this->salary,
            'city' => $this->city,
            'created_by' => $this->createdBy->name,
            'created_at' => $this->created_at->format('Y-m-d'),
            'status' => $this->status,
        ];
    }
}
