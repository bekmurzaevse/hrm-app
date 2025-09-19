<?php

namespace App\Actions\v1\Project\File;

use App\Dto\v1\Project\File\UploadDto;
use App\Exceptions\ApiResponseException;
use App\Helpers\FileUploadHelper;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UploadAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\v1\Project\File\UploadDto $dto
     * @return JsonResponse
     * @throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $id, UploadDto $dto): JsonResponse
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
                code: 201,
                message: "Uploaded file to Project",
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Project Not Found', 404);
        }
    }
}
