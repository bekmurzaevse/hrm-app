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

    /**
     * Summary of __invoke
     * @param int $id
     * @param int $educationId
     * @param \App\Dto\Candidate\UpdateEducationDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, int $educationId, UpdateEducationDto $dto): JsonResponse
    {
        try {
            $education = Education::findOrFail($educationId);

            $oldData = $education->only([
                'title', 'degree', 'specialty', 'candidate_id', 'start_year', 'endYear', 'description'
            ]);

            $education->update([
                'title'        => $dto->title,
                'degree'       => $dto->degree,
                'specialty'    => $dto->specialty,
                'candidate_id' => $id,
                'start_year'   => $dto->startYear,
                'endYear'      => $dto->endYear,
                'description'  => $dto->description,
            ]);

            logActivity(
                "Образование обновлено!",
                "У кандидата {$education->candidate->first_name} {$education->candidate->last_name} было обновлено образование $education->title).
                 Старые данные: " . json_encode($oldData, JSON_UNESCAPED_UNICODE) .
                 " | Новые данные: " . json_encode([
                    'title'       => $dto->title,
                    'degree'      => $dto->degree,
                    'specialty'   => $dto->specialty,
                    'candidate_id'=> $id,
                    'start_year'  => $dto->startYear,
                    'endYear'     => $dto->endYear,
                    'description' => $dto->description,
                 ], JSON_UNESCAPED_UNICODE)
            );

            return static::toResponse(
                message: "$id - id li candidate tin' education jan'alandi!",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Candidate not found', 404);
        }
    }
}
