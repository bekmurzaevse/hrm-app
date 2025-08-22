<?php

namespace App\Actions\v1\Client;

use App\Exceptions\ApiResponseException;
use App\Models\Client;
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
            $client = Client::findOrFail($id);

            $file = $client->files()->where('id', $fileId)->firstOrFail();

            if (Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }

            $client->files()->findOrFail($fileId)->delete();

            logActivity(
                "Удаление файла клиента",
                "Файл '{$file->name}' (ID: {$fileId}) был удалён у клиента '{$client->name}' (ID: {$client->id})",
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
