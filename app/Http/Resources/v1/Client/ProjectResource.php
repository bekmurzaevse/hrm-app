<?php

namespace App\Http\Resources\v1\Client;

use App\Http\Resources\v1\File\FileResource;
use App\Http\Resources\v1\Vacancy\ClientVacancyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'status' => $this->status,
            'contract' => $this->contract_number,
            'deadline' => $this->deadline->format('Y-m-d'),
            'performers' => $this->whenLoaded('performers', function () {
                return $this->performers->map(fn($performer) => [
                    'first_name' => $performer->first_name,
                    'last_name'  => $performer->last_name,
                    'patronymic' => $performer->patronymic,
                ]);
            }),
        ];
    }
}
