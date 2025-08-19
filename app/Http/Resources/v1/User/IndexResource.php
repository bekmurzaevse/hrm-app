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
            'full_name' => $this->first_name . " " . $this->last_name . " " . $this->patronymic,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
