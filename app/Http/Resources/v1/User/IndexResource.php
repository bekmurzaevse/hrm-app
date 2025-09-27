<?php

namespace App\Http\Resources\v1\User;

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
            'full_name' => $this->first_name . " " . $this->last_name . " " . $this->patronymic,
            'position' => $this->position,
            'roles' => $this->getRoleNames(),
            'status' => $this->status,
            'email' => $this->email,
            'phone' => $this->phone,
            'projects' => [
                'in_progress' => $this->projects()->where('status', 'in_progress')->count(),
                'cancelled' => $this->projects()->where('status', 'cancelled')->count(),
            ],
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
