<?php

namespace App\Actions\v1\Project;

use App\Exceptions\ApiResponseException;
use App\Models\File;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadFileAction
{
    public function __invoke(int $id, int $fileId): BinaryFileResponse
    {
        try {
            $file = Project::findOrFail($id)
                ->files()
                ->findOrFail($fileId);

            if (!Storage::disk('public')->exists($file->path)) {
                throw new ApiResponseException('File Not Found', 404);
            }

            return response()->download(
                file: Storage::disk('public')->path($file->path),
                name: $file->name,
            );
        } catch (ModelNotFoundException $e) {
            if ($e->getModel() === Project::class) {
                throw new ApiResponseException('Project Not Found', 404);
            }
            if ($e->getModel() === File::class) {
                throw new ApiResponseException('File Not Found', 404);
            }
        }
    }
}
