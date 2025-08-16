<?php

namespace App\Actions\v1\Candidate;

use App\Exceptions\ApiResponseException;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteContactAction
{
    use ResponseTrait;

    public function __invoke(int $id, int $contactId): JsonResponse
    {
        try {
            Candidate::findOrFail($id)->contacts()->findOrFail($contactId)->delete();

            return static::toResponse(
                message: "$id - id li Contact o'shirildi!",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Candidate or Contact Not Found', 404);
        }
    }
}
