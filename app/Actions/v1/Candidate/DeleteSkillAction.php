<?php

namespace App\Actions\v1\Candidate;

use App\Exceptions\ApiResponseException;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteSkillAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param int $skillId
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, int $skillId): JsonResponse
    {
        try {
            $candidate = Candidate::findOrFail($id);

            $skill = $candidate->skills()->findOrFail($skillId);

            $skillName = $skill->name ?? "ID {$skillId}";

            $skill->delete();

            logActivity(
                "Навык удалён!",
                "У кандидата $candidate->fist_name $candidate->fist_name был удалён навык: {$skillName} (ID {$skillId})."
            );

            return static::toResponse(
                message: "$id - id li Skill o'shirildi!",
            );
        } catch (ModelNotFoundException $ex) {
            $model = class_basename($ex->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
