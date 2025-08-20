<?php

namespace App\Actions\v1\Candidate;

use App\Exceptions\ApiResponseException;
use App\Models\WorkExperience;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteExperienceAction
{
    use ResponseTrait;

    public function __invoke(int $id): JsonResponse
    {
        try {
            // WorkExperience::findOrFail($id)->delete();
            $experience = WorkExperience::findOrFail($id);

            $expInfo = $experience->company ?? "Опыт работы #{$id}";
            $candidateId = $experience->candidate_id;

            $experience->delete();

            logActivity(
                "Опыт работы удалён!",
                "У кандидата (ID {$candidateId}) был удалён опыт работы: {$expInfo} (ID {$id})."
            );

            return static::toResponse(
                message: "$id - id li Work experience o'shirildi!",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Work experince Not Found', 404);
        }
    }
}
