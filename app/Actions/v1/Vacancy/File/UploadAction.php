<?php

namespace App\Actions\v1\Vacancy\File;

use App\Dto\Vacancy\File\UploadDto;
use App\Helpers\FileUploadHelper;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class UploadAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\Vacancy\File\UploadDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, UploadDto $dto): JsonResponse
    {
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
    }
}