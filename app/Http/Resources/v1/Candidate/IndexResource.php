<?php

namespace App\Http\Resources\v1\Candidate;

use App\Http\Resources\v1\Interaction\LastContactResource;
use Carbon\Carbon;
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
            'full_name' => $this->first_name . ' ' . $this->last_name . ' ' . $this->patronymic,
            'age' => Carbon::parse($this->birth_date)->age,
            'status' => $this->status,
            'workplace' => $this->workplace,
            'position' => $this->position,
            'last_contact' => new LastContactResource($this->interactions()->orderBy('created_at', 'desc')->first()),
            'experience' => $this->experience,
            'source' => $this->source,
            'desired_salary' => $this->desired_salary,
        ];
    }
}
