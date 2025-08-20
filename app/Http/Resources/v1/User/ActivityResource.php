<?php

namespace App\Http\Resources\v1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user->first()->first_name,
            'title' => $this->title,
            'text' => $this->text,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
