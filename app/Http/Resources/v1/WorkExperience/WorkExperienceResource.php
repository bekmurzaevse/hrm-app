<?php

namespace App\Http\Resources\v1\WorkExperience;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkExperienceResource extends JsonResource
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
            'company' => $this->company,
            'position' => $this->position,
            'start_work' => $this->start_work,
            'end_work' => $this->end_work,
            'description' => $this->description,
        ];
    }
}
