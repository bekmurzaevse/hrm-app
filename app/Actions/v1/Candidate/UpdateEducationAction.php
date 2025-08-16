<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\UpdateEducationDto;
use App\Exceptions\ApiResponseException;
use App\Models\Education;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateEducationAction
{
    use ResponseTrait;

    public function __invoke(int $id, int $educationId, UpdateEducationDto $dto): JsonResponse
    {
        try {
            Education::findOrFail($educationId)->update([
                'title' => $dto->title,
                'degree' => $dto->degree,
                'specialty' => $dto->specialty,
                'candidate_id' => $id,
                'start_year' => $dto->startYear,
                'endYear' => $dto->endYear,
                'description' => $dto->description,
            ]);

            return static::toResponse(
                message: "$id - id li candidate tin' education jan'alandi!",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Candidate not found', 404);
        }
    }
}
