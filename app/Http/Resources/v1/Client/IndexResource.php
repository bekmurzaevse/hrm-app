<?php

namespace App\Http\Resources\v1\Client;

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
            'name' => $this->name,
            'leader' => $this->leader,
            'status' => $this->status,
            'contact_person' => $this->contact_person,
            // 'contacts' => $this->contacts,
            'user_id' => $this->user_id,
            // 'vacancies' => $this->vacancies,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
