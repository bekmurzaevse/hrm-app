<?php

namespace App\Actions\v1\Candidate;

use App\Exceptions\ApiResponseException;
use App\Models\Education;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteEducationAction
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
            Education::findOrFail($id)->delete();

            return static::toResponse(
                message: "$id - id li file o'shirildi",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Education Not Found', 404);
        }
    }
}
