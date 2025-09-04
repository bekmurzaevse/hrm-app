<?php

namespace App\Http\Resources\v1\Education;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
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
            'degree' => $this->degree,
            'specialty' => $this->specialty,
            'start_year' => $this->start_year,
            'end_year' => $this->end_year,
            'description' => $this->description,
        ];
    }
}
