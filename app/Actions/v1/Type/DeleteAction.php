<?php

namespace App\Actions\v1\Type;

use App\Exceptions\ApiResponseException;
use App\Models\Type;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

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
            $type = Type::findOrFail($id);
            $title = $type->title;
            $type->delete();

            logActivity(
                "Тип удалён!",
                "Тип '{$title}' (ID: {$id}) был успешно удалён в файле " . __FILE__
            );

            return static::toResponse(
                message: "$id - id li type o'shirildi",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Type Not Found', 404);
        }
    }
}
