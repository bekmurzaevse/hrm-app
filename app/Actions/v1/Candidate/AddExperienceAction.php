<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\AddExperienceDto;
use App\Exceptions\ApiResponseException;
use App\Http\Requests\v1\Candidate\AddWorkExperienceRequest;
use App\Models\Candidate;
use App\Models\WorkExperience;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class AddExperienceAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\Candidate\AddExperienceDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, AddExperienceDto $dto): JsonResponse
    {
        try {
            $candidate = Candidate::findOrFail($id);
            $experience = WorkExperience::create([
                'company' => $dto->company,
                'position' => $dto->position,
                'candidate_id' => $id,
                'start_work' => $dto->startWork,
                'end_work' => $dto->endWork,
                'description' => $dto->description,
            ]);

            logActivity(
                "Опыт работы добавлен!",
                "Кандидату с $candidate->first_name $candidate->last_name добавлен новый опыт работы в компании {$experience->company} на должности {$experience->position}."
            );

            return static::toResponse(
                message: "$id - id li candidate qa work experience qosildi!",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Candidate Not Found!', 404);
        }
    }
}
