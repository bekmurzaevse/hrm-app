<?php

namespace App\Actions\v1\Vacancy\File;

use App\Exceptions\ApiResponseException;
use App\Models\File;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DeleteFileAction
{
    use ResponseTrait;

    public function __invoke(int $id, int $fileId): JsonResponse
    {
        try {
            $file = Vacancy::findOrFail($id)
                ->files()
                ->findOrFail($fileId);

            if (!Storage::disk('public')->exists($file->path)) {
                throw new ApiResponseException('File Not Found', 404);
            }
            Storage::disk('public')->delete($file->path);
            $file->delete();

            return static::toResponse(
                message: 'File deleted successfully',
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
