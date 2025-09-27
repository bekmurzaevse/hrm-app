<?php

namespace App\Http\Resources\v1\Vacancy;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'main_info' => [
                'title' => $this->title,
                'client' => $this->client?->name,
                'salary' => $this->salaryDetail,
                'region' => $this->district?->region?->title,
                'district' => $this->district?->title,
                'type_employment' => $this->type_employment,
                'work_experience' => $this->work_experience,
                'position_count' => $this->position_count,
                'bonus' => $this->bonus,
                'probation' => $this->probation,
                'probation_salary' => $this->probation_salary,
            ],
            'detail' => [
                'desription' => $this->description,
                'requirements' => $this->requirements,
                'responsibilities' => $this->responsibilities,
                'work_conditions' => $this->work_conditions,
                'benefits' => $this->benefits,
            ],
            'skills' => $this->skills?->map->only(['id', 'title']),
            'contact_info' => [
                'contact_person' => $this->client?->contact_person,
                'position' => $this->client?->person_position,
                'phone' => $this->client?->person_phone,
                'email' => $this->client?->person_email,
            ],
            'status' => $this->status,
            'position_count' => $this->position_count,
            'region' => $this->district?->region?->title,
            'district' => $this->district?->title,
            'key_data' => [
                'created_at' => $this->created_at?->format('Y-m-d'),
                'created_by' => $this->createdBy?->shortFio,
            ],
            'files' => $this->files?->map(function ($file) {
                $fileExists = Storage::disk('public')->exists($file->path);
                return [
                    'id' => $file->id,
                    'name' => $file->name,
                    'type' => $file->type,
                    'size' => round($file->size / 1024, 2) . ' KB',
                    // TODO: add creator of File
                    'created_at' => $file->created_at->format('Y-m-d'),
                    'download_url' => $fileExists ? url("/api/v1/vacancies/{$this->id}/download/{$file->id}") : null,
                ];
            }),
        ];
    }
}
