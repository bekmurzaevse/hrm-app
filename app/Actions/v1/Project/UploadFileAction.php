<?php

namespace App\Actions\v1\Project;

use App\Dto\Project\UploadFileDto;
use App\Exceptions\ApiResponseException;
use App\Helpers\FileUploadHelper;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UploadFileAction
{
    use ResponseTrait;

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

            return static::toResponse(
                message: "Uploaded file to Project-{$id}",
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Project Not Found', 404);
        }
    }
}