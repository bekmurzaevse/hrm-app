<?php

namespace App\Actions\v1\Candidate\Experience;

use App\Dto\v1\Candidate\Experience\AddExperienceDto;
use App\Exceptions\ApiResponseException;
use App\Models\Candidate;
use App\Models\WorkExperience;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class AddExperienceAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\v1\Candidate\Experience\AddExperienceDto $dto
     * @return JsonResponse
     *@throws \App\Exceptions\ApiResponseException
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

            $date1 = Carbon::parse($dto->startWork);
            $date2 = Carbon::parse($dto->endWork);

            $monthsDifference = (int) $date1->diffInMonths($date2);
            $total = $monthsDifference + $candidate->experience ?? 0;

            $candidate->update([
                'experience' => $total,
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
