<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\UpdateExperienceDto;
use App\Exceptions\ApiResponseException;
use App\Models\WorkExperience;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateExperienceAction
{
    use ResponseTrait;

    public function __invoke(int $id, int $workId, UpdateExperienceDto $dto): JsonResponse
    {
        try {
            WorkExperience::findOrFail($workId)->update([
                'company' => $dto->company,
                'position' => $dto->position,
                'candidate_id' => $id,
                'start_work' => $dto->startWork,
                'end_work' => $dto->endWork,
                'description' => $dto->description,
            ]);

            return static::toResponse(
                message: "$id - id li candidate tin' work experience jan'alandi!",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Error', 404);
        }
    }
}
