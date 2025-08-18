<?php

namespace App\Actions\v1\Vacancy;

use App\Exceptions\ApiResponseException;
use App\Models\Vacancy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadFileAction
{
    public function __invoke(int $id, int $fileId): BinaryFileResponse
    {
        try {
            $file = Vacancy::findOrFail($id)
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
            $model = class_basename($e->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
