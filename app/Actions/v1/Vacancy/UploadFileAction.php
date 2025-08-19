<?php

namespace App\Actions\v1\Vacancy;

use App\Dto\Vacancy\UploadFileDto;
use App\Exceptions\ApiResponseException;
use App\Helpers\FileUploadHelper;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UploadFileAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\Vacancy\UploadFileDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, UploadFileDto $dto): JsonResponse
    {
        try {
            $vacancy = Vacancy::findOrFail($id);

            $uploadedFile = FileUploadHelper::file($dto->file, "vacancies/" . $id);

            $vacancy->files()->create([
                'name' => $uploadedFile['name'],
                'path' => $uploadedFile['path'],
                'size' => $uploadedFile['size'],
                'type' => $dto->type,
            ]);

            return static::toResponse(
                message: "Uploaded file to Vacancy-{$id}",
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Vacancy Not Found', 404);
        }
    }
}