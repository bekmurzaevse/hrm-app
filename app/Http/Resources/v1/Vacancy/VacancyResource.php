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
                'client' => $this->client->name,
                'salary' => $this->salaryDetail,
                'city' => $this->city,
                'type_employment' => $this->type_employment,
                'work_experience' => $this->work_experience,
                'position_count' => $this->position_count,
                'bonus' => $this?->bonus,
                'probation' => $this?->probation,
                'probation_salary' => $this?->probation_salary,
            ],
            'detail' => [
                'desription' => $this->description,
                'requirements' => $this->requirements,
                'responsibilities' => $this->responsibilities,
                'work_conditions' => $this->work_conditions,
                'benefits' => $this?->benefits,
            ],
            'skills' => $this->skills->map->only(['id', 'title']),
            // TODO: Add main contact person details after creating maincontact for clients
            'contact_info' => $this->client->contactPersons->first()->only([
                'id',
                'full_name',
                'position',
                'phone',
                'email',
            ]),
            'status' => $this->status,
            'position_count' => $this->position_count,
            'city' => $this?->city,
            'key_data' => [
                'created_at' => $this->created_at->format('Y-m-d'),
                'craeted_by' => $this->creator,
            ],
            'files' => $this->files->map(function ($file) {
                $fileExists = Storage::disk('public')->exists($file->path);
                return [
                    'id' => $file->id,
                    'name' => $file->name,
                    'type' => $file->type,
                    'size' => round($file->size / 1024, 2) . ' KB',
                    // TODO: add creator of File
                    'created_at' => $file->created_at->format('Y-m-d'),
                    'download_url' => $fileExists ? url('/api/v1/vacancies/' . $this->id . '/download/' . $file->id) : null,
                    'show_url' => $fileExists ? url('/api/v1/vacancies/' . $this->id . '/file/' . $file->id) : null,
                ];
            }),
        ];
    }
}
