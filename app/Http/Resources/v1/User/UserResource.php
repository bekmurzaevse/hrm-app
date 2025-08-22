<?php

namespace App\Http\Resources\v1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'patronymic' => $this->patronymic,
            'status' => $this->status,
            'contact_info' => [
                'phone' => $this->phone,
                'email' => $this->email,
                'birth_date' => $this->birth_date,
                'address' => $this->address,
            ],
            'work_info' => [
                'position' => $this->position,
                'role' => null,
                'created_at' => $this->created_at->format('Y-m-d'),
            ],
            'projects' => ProjectResource::collection($this->projects),
            'activities' => ActivityResource::collection($this->activities),
            'stats' => [
                'projects_count' => $this->projects->count(),
                'active' => $this->projects()->where('status', 'in_progress')->count(),
                'cancelled' => $this->projects()->where('status', 'cancelled')->count(),
            ],
        ];
    }
}
