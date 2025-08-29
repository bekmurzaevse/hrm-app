<?php

namespace App\Actions\v1\Candidate\Experience;

use App\Exceptions\ApiResponseException;
use App\Models\WorkExperience;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteExperienceAction
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
            $experience = WorkExperience::findOrFail($id);

            $expInfo = $experience->company ?? "Опыт работы #{$id}";
            $candidate = $experience->candidate;

            $experience->delete();

            logActivity(
                "Опыт работы удалён!",
                "У кандидата $candidate->first_name $candidate->last_name был удалён опыт работы: {$expInfo} (ID {$id})."
            );

            return static::toResponse(
                message: "$id - id li Work experience o'shirildi!",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Work experince Not Found', 404);
        }
    }
}
