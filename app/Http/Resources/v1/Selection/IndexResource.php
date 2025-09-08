<?php

namespace App\Http\Resources\v1\Selection;

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
            'title' => $this->title,
            'creator' => $this->createdBy?->last_name . ' ' . mb_substr($this->createdBy?->first_name, 0, 1, 'UTF-8') . '.' . mb_substr($this->createdBy?->patronymic, 0, 1, 'UTF-8'),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
