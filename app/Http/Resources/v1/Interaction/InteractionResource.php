<?php

namespace App\Http\Resources\v1\Interaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InteractionResource extends JsonResource
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
            'type' => $this->type->title,
            'created_at' => $this->created_at->format('Y-m-d'),
            'value' => $this->value,
            'description' => $this->description,
            'user' => $this->user->name,
        ];
    }
}
