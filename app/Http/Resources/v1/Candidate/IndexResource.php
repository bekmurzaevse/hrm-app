<?php

namespace App\Http\Resources\v1\Candidate;

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
        // dd($this->birth_date->format('Y-m-d'));
        return [
            'full_name' => $this->first_name . ' ' . $this->last_name . ' ' . $this->patronymic,
            'age' => now()->year - $this->birth_date->year,
            'status' => $this->status,
            'workplace' => $this->workplace,
            'position' => $this->position,
            'last_contact' => $this->updated_at->format('Y-m-d') ?? $this->created_at->format('Y-m-d'),
            'city' => $this->city,
            'salary' => $this->salary,
        ];
    }
}
