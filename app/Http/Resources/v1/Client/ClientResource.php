<?php

namespace App\Http\Resources\v1\Client;

use App\Http\Resources\v1\File\FileResource;
use App\Http\Resources\v1\Vacancy\ClientVacancyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'main_info' => [
                'name' => $this->name,
                'leader' => $this->leader,
                'activity' => $this->activity,
                'employee_count' => $this->employee_count,
                'INN' => $this->INN,
                'status' => $this->status,
                'description' => $this->description,
            ],
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'contact_person' => [
                'full_name' => $this->contact_person,
                'position' => $this->person_position,
                'phone' => $this->person_phone,
                'email' => $this->person_email,
            ],
            'info' => [
                'source' => $this->source,
                'created_by' => $this->user->first_name . ' ' . $this->user->last_name . ' ' . $this->user->patronymic,
                'created_at' => $this->created_at->format('Y-m-d'),
                'updated_at' => $this->updated_at->format('Y-m-d'),
            ],
            'stats' => [
                'all_vacancies' => $this->vacancies()->count(),
                'open_vacancies' => $this->vacancies()->where('status', 'open')->count(),
                'close_vacancies' => $this->vacancies()->where('status', 'closed')->count(),
            ],
            'vacancies' => ClientVacancyResource::collection($this->vacancies),
            'projects' => ProjectResource::collection($this->projects),
            'files' => FileResource::collection($this->files),
            'notes' => $this->notes,
        ];
    }
}
