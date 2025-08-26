<?php

namespace App\Actions\v1\Candidate\Education;

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
            $education = Education::findOrFail($id);

            $eduInfo = $education->institution ?? "Образование #{$id}";
            $education->delete();

            logActivity(
                "Образование удалено!",
                "У кандидата {$education->candidate->first_name} было удалено образование: {$eduInfo} (ID {$id})."
            );

            return static::toResponse(
                message: "$id - id li file o'shirildi",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Education Not Found', 404);
        }
    }
}
