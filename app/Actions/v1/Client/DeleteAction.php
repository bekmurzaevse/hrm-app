<?php

namespace App\Actions\v1\Client;

use App\Exceptions\ApiResponseException;
use App\Models\Client;
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
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $client = Client::findOrFail($id);

            $oldData = $client->only([
                'id', 'name', 'status', 'leader', 'contact_person',
                'person_position', 'person_phone', 'person_email',
                'phone', 'email', 'address',
                'user_id', 'INN', 'employee_count', 'source', 'activity',
                'description', 'notes'
            ]);

            $client->files()->delete();

            Storage::disk('public')->deleteDirectory("clients/$client->id");

            $client->delete();

            logActivity(
                "Client Deleted!",
                "Клиент '{$oldData['name']}' удалён",
            );

            return static::toResponse(
                message: "$id - id li client o'shirildi",
            );
        } catch (ModelNotFoundException $ex) {
            $model = class_basename($ex->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
