<?php

namespace App\Actions\v1\Candidate\File;

use App\Exceptions\ApiResponseException;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DeleteFileAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param int $fileId
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, int $fileId): JsonResponse
    {
        try {
            $candidate = Candidate::findOrFail($id);

            $file = $candidate->files()->where('id', $fileId)->firstOrFail();

            if (Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }

            $fileName = $file->name ?? $file->path;
            $candidate->files()->findOrFail($fileId)->delete();

            logActivity(
                "Файл удалён!",
                "У кандидата ($candidate->first_name $candidate->last_name) был удалён файл: {$fileName} (ID {$fileId})."
            );

            return static::toResponse(
                message: "$id - id li file o'shirildi",
            );
        } catch (ModelNotFoundException $ex) {
            $model = class_basename($ex->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
