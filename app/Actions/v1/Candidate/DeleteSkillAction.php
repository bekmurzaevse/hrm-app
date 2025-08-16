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

    public function __invoke(int $id, int $skillId): JsonResponse
    {
        try {
            Candidate::findOrFail($id)->skills()->findOrFail($skillId)->delete();

            return static::toResponse(
                message: "$id - id li Skill o'shirildi!",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Candidate or Skill Not Found', 404);
        }
    }
}
