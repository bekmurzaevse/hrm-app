<?php

namespace App\Http\Resources\v1\Interaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LastContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at->format('Y-m-d'),
            'user' => $this->user->first_name . ' ' . $this->user->last_name,
        ];
    }
}
