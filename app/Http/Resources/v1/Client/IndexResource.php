<?php

namespace App\Http\Resources\v1\Client;

use App\Http\Resources\v1\Contact\ContactResource;
use App\Models\Client;
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
            'clients_count' => Client::count(),
            'active_count' => Client::where('status', 'Active')->count(),
            'potential_count' => Client::where('status', 'Potential')->count(),
            'inactive_count' => Client::where('status', 'Inactive')->count(),
            'name' => $this->name,
            'leader' => $this->leader,
            'status' => $this->status,
            'contact_person' => $this->contact_person,
            'contacts' => ContactResource::collection($this->contacts),
            'user_id' => $this->user_id,
            // 'vacancies' => $this->vacancies,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
