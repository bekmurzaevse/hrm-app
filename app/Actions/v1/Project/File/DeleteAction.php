<?php

namespace App\Actions\v1\Project\File;

use App\Exceptions\ApiResponseException;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DeleteAction
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
            $project = Project::findOrFail($id);
            $file = $project->files()
                ->findOrFail($fileId);

            if (!Storage::disk('public')->exists($file->path)) {
                throw new ApiResponseException('File Not Found', 404);
            }
            Storage::disk('public')->delete($file->path);

            // Log user activity
            logActivity(
                "Файл удалён",
                "Из проекта «{$project->title}» был удалён файл «{$file->name}»."
            );

            $file->delete();

            return static::toResponse(
                message: 'File deleted successfully',
            );
        } catch (ModelNotFoundException $e) {
            $model = class_basename($e->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
