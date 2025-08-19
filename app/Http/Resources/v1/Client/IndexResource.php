<?php

namespace App\Http\Resources\v1\Client;

use App\Http\Resources\v1\Contact\ContactResource;
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
            'address' => $this->address,
            'status' => $this->status,
            'contact_person' => [
                'full_name' => $this->contact_person,
                'position' => $this->person_position,
                'phone' => $this->person_phone,
                'email' => $this->person_email,
            ],
            'contacts' => ContactResource::collection($this->contacts),
            'user_id' => $this->user_id,
            // 'vacancies' => $this->vacancies,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
