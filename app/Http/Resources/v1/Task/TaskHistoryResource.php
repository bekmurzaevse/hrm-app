<?php

namespace App\Http\Resources\v1\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'comment' => $this->comment,
            'changed_by' => [
                'id' => $this->changedBy?->id,
                'name' => trim($this->changedBy?->first_name . ' ' . $this->changedBy?->last_name),
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}