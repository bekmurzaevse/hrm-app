<?php

namespace App\Http\Resources\v1\Project;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
                'client' => [
                    'id' => $this->client?->id,
                    'name' => $this->client?->name,
                ],
                'vacancy' => [
                    'id' => $this->vacancy?->id,
                    'title' => $this->vacancy?->title,
                ],
                'performers' => $this->performers_fio,
                'description' => $this->description,
                'comment' => $this->comment,
            ],
            'finance_info' => [
                'created_at' => $this->created_at->format('Y-m-d'),
                'deadline' => $this->deadline->format('Y-m-d'),
                'contract_number' => $this->contract_number,
                'contract_budget' => $this->contract_budget !== null ? ($this->contract_budget . ' ' . $this->contract_currency) : null,
                'progress' => $this->progress,
            ],
            'requirements' => [
                'requirements' => $this->vacancy?->requirements,
                'work_conditions' => $this->vacancy?->work_conditions,
                'salary' => $this->vacancy?->salaryDetail,
                'benefits' => $this->vacancy?->benefits,
            ],
            'files' => $this->files?->map(function ($file) {
                $fileExists = Storage::disk('public')->exists($file->path);
                return [
                    'id' => $file->id,
                    'name' => $file->name,
                    'type' => $file->type,
                    'size' => round($file->size / 1024, 2) . ' KB',
                    // TODO: add file category
                    'created_at' => $file->created_at->format('Y-m-d'),
                    // TODO: add file created by
                    'download_url' => $fileExists ? url('/api/v1/projects/' . $this->id . '/download/' . $file->id) : null,
                    'show_url' => $fileExists ? url('/api/v1/projects/' . $this->id . '/file/' . $file->id) : null,
                ];
            }),
        ];
    }
}
