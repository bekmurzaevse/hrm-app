<?php

namespace App\Actions\v1\Vacancy\File;

use App\Exceptions\ApiResponseException;
use App\Models\File;
use App\Models\Vacancy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadAction
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
            if ($e->getModel() === Vacancy::class) {
                throw new ApiResponseException('Vacancy Not Found', 404);
            }
            if ($e->getModel() === File::class) {
                throw new ApiResponseException('File Not Found', 404);
            }
        }
    }
}
