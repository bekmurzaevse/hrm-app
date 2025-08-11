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
                'KPP' => $this->KPP,
            ],
            // 'contacts' => ContactResource::collection($this->contacts),
            'contact_persons' => $this->contactPersons,
            'vacancies' => ClientVacancyResource::collection($this->vacancies),
            // 'candidates' => $this->candidates,
            'files' => FileResource::collection($this->files),
        ];
    }
}
