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
            Type::findOrFail($id)->delete();

            return static::toResponse(
                message: "$id - id li type o'shirildi",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Type Not Found', 404);
        }
    }
}
