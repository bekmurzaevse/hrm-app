<?php

namespace App\Actions\v1\Vacancy\File;

use App\Dto\v1\Vacancy\File\UploadDto;
use App\Exceptions\ApiResponseException;
use App\Helpers\FileUploadHelper;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UploadAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\v1\Vacancy\File\UploadDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, UploadDto $dto): JsonResponse
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

            // Log user activity
            $title = 'Файл загружен';
            $text = "Файл был загружен в вакансию «{$vacancy->title}».";
            logActivity($title, $text);

            return static::toResponse(
                message: "Uploaded file to Vacancy",
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Vacancy Not Found', 404);
        }
    }
}
