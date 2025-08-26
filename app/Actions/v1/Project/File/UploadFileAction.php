<?php

namespace App\Actions\v1\Project\File;

use App\Dto\v1\Project\File\UploadFileDto;
use App\Exceptions\ApiResponseException;
use App\Helpers\FileUploadHelper;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UploadFileAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\v1\Project\File\UploadFileDto $dto
     * @return JsonResponse
     *@throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $id, UploadFileDto $dto): JsonResponse
    {
        try {
            $project = Project::findOrFail($id);

            $uploadedFile = FileUploadHelper::file($dto->file, "projects/" . $id);

            $project->files()->create([
                'name' => $uploadedFile['name'],
                'path' => $uploadedFile['path'],
                'size' => $uploadedFile['size'],
                'type' => $dto->type,
            ]);

            // Log user activity
            logActivity(
                "Файл загружен",
                "В проект «{$project->title}» был загружен файл «{$uploadedFile['name']}»."
            );

            return static::toResponse(
                message: "Uploaded file to Project-{$id}",
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Project Not Found', 404);
        }
    }
}
