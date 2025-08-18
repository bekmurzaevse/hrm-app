<?php

namespace App\Http\Resources\v1\Project;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            "status" => $this->status,
            'stages' => StageResource::collection($this->stages),
            'main_info' => [
                'title' => $this->title,
                'client_name' => $this->client->name,
                'vacancy_title' => $this->vacancy->title,
                'performers' => $this->performers_fio,
                'description' => $this->description,
                'comment' => $this->comment,

                'created_at' => $this->created_at->format('Y-m-d'),
                'deadline' => $this->deadline->format('Y-m-d'),
                'contract_number' => $this->contract_number,
                'contract_budget' => $this->contract_budget . ' ' . $this->contract_currency,
                'progress' => $this->progress,
            ],
            'files' => $this->files?->map(function ($file) {
                // $fileExists = Storage::disk('public')->exists($this->path);
                return [
                    'id' => $file->id,
                    'name' => $file->name,
                    'size' => round($file->size / 1024, 2) . ' KB',
                    'type' => $file->type,
                    'path' => $file->path,
                    'download_url' => null // TODO: Implement download URL logic
                    // 'download_url' => $fileExists ? url('/api/v1/files/' . $file->id . '/download') : null,
                    // 'download_url' => url('/api/v1/files/' . $file->id . '/download'),
                ];
            }),
        ];
    }
}
