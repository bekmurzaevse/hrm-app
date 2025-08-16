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
            'main_info' => [
                'title' => $this->title,
                'client' => $this->client->name,
                'salary' => $this->vacancySalary?->salaryDetail,
                'city' => $this->city,
                'type_employment' => $this->type_employment,
                'work_experience' => $this->work_experience,
                'position_count' => $this->position_count,
                'bonus' => $this->vacancySalary?->bonus,
                'probation' => $this->vacancySalary?->probation,
                'probation_salary' => $this->vacancySalary?->probation_salary,
            ],
            'detail' => [
                'detail_id' => $this->vacancyDetail?->id,
                'desription' => $this->vacancyDetail?->description,
                'requirements' => $this->vacancyDetail?->requirements,
                'responsibilities' => $this->vacancyDetail?->responsibilities,
                'work_conditions' => $this->vacancyDetail?->work_conditions,
                'benefits' => $this->vacancyDetail?->benefits,
            ],
            'skills' => $this->skills?->map->only(['id', 'title']),
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
            'city' => $this->city,
            'key_data' => [
                'created_at' => $this->created_at->format('Y-m-d'),
                'craeted_by' => sprintf(
                    '%s %s.%s',
                    $this->createdBy->last_name,
                    mb_substr($this->createdBy->first_name, 0, 1, 'UTF-8'),
                    mb_substr($this->createdBy->patronymic, 0, 1, 'UTF-8')
                ),
            ],
            'files' => $this->files?->map(function ($file) {
                // $fileExists = Storage::disk('public')->exists($this->path);
                return [
                    'id' => $file->id,
                    'name' => $file->name,
                    'size' => round($file->size / 1024, 2) . ' KB',
                    'type' => $file->type,
                    'path' => $file->path,
                    'download_url' => null // TODO: Implement download URL logic
                    // 'download_url' => $fileExists ? url('/api/v1/files/' . $file->id . '/download') : null,
                    // 'download_url' => url('/api/v1/files/' . $file->id . '/download'),
                ];
            }),
        ];
    }
}
