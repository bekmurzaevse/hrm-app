<?php

namespace App\Http\Resources\v1\Photo;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $fileExists = Storage::disk('public')->exists($this->path);

        return [
            'name' => $this->name,
            'path' => $this->path,
            'size' => $fileExists ? round(Storage::disk('public')->size($this->path) / 1024, 2) . " KB" : null,
            // 'download_url' => $fileExists ? url('/api/v1/clients/' . $this->additional['client_id'] . '/download/' . $this->id) : null,
        ];
    }
}
