<?php

namespace App\Actions\v1\Client;

use App\Dto\Client\UploadDto;
use App\Exceptions\ApiResponseException;
use App\Helpers\FileUploadHelper;
use App\Models\Client;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UploadAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\Client\UploadDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, UploadDto $dto): JsonResponse
    {
        try {
            $client = Client::findOrFail($id);

            $uploadedFiles = FileUploadHelper::files($dto->files, "clients/{$client->id}");

            array_map(function ($file) use ($client) {
                $client->files()->create($file);
            }, $uploadedFiles);

            $fileNames = array_map(fn($f) => $f['original_name'] ?? $f['name'] ?? 'unknown', $uploadedFiles);

            logActivity(
                "Загрузка файлов",
                "Клиент '{$client->name}' (ID: {$client->id}) загрузил(а) следующие файлы: " . implode(', ', $fileNames)
            );

            return static::toResponse(
                message: 'Uploaded files to client ' . $client->id
            );
        } catch (ModelNotFoundException $ex) {
            $model = class_basename($ex->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
