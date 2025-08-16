<?php

namespace App\Actions\v1\Candidate;

use App\Exceptions\ApiResponseException;
use App\Models\Language;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteLanguageAction
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
            Language::findOrFail($id)->delete();

            return static::toResponse(
                message: "$id - id li Language o'shirildi!",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Language Not Found', 404);
        }
    }
}
