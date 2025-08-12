<?php

namespace App\Http\Resources\v1\Vacancy;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VacancyResource extends JsonResource
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
            'city' => $this->city,
            'type' => $this->type_employment,
            'temporary_from' => $this->temporary_from?->format('Y-m-d'),
            'temporary_to' => $this->temporary_to?->format('Y-m-d'),
            'salary' => $this->salary,
            'salary_period' => $this->salary_period,
            'created_by' => $this->createdBy->name,
            'status' => $this->status,
            'probation_period' => $this->probationPeriod,
            'probation_salary_amount' => $this->probation_salary_amount,
            'probation_salary_period' => $this->probation_salary_period,
            'experience' => $this->experience,
            'employee_count' => $this->employee_count,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
