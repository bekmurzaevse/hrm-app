<?php

namespace App\Actions\v1\Candidate\Experience;

use App\Dto\v1\Candidate\Experience\UpdateExperienceDto;
use App\Exceptions\ApiResponseException;
use App\Models\WorkExperience;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateExperienceAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param int $workId
     * @param \App\Dto\v1\Candidate\Experience\UpdateExperienceDto $dto
     * @return JsonResponse
     *@throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $id, int $workId, UpdateExperienceDto $dto): JsonResponse
    {
        try {
            $experience = WorkExperience::findOrFail($workId);

            $oldData = $experience->only([
                'company', 'position', 'candidate_id', 'start_work', 'end_work', 'description'
            ]);

            $experience->update([
                'company'      => $dto->company,
                'position'     => $dto->position,
                'candidate_id' => $id,
                'start_work'   => $dto->startWork,
                'end_work'     => $dto->endWork,
                'description'  => $dto->description,
            ]);

            logActivity(
                "Опыт работы обновлён!",
                "У кандидата {$experience->candidate->first_name} {$experience->candidate->lst_nme} был обновлён опыт работы {$experience->compny} $experience->position).
                 Старые данные: " . json_encode($oldData, JSON_UNESCAPED_UNICODE) .
                 " | Новые данные: " . json_encode([
                    'company'      => $dto->company,
                    'position'     => $dto->position,
                    'candidate_id' => $id,
                    'start_work'   => $dto->startWork,
                    'end_work'     => $dto->endWork,
                    'description'  => $dto->description,
                 ], JSON_UNESCAPED_UNICODE)
            );

            return static::toResponse(
                message: "$id - id li candidate tin' work experience jan'alandi!",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Error', 404);
        }
    }
}
