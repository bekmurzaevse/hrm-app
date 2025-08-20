<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\AddEducationDto;
use App\Exceptions\ApiResponseException;
use App\Models\Candidate;
use App\Models\Education;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class AddEducationAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\Candidate\AddEducationDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, AddEducationDto $dto): JsonResponse
    {
        try {
            $candidate = Canpdidate::findOrFail($id);
            $data = [
                'title' => $dto->title,
                'degree' => $dto->degree,
                'specialty' => $dto->specialty,
                'start_year' => $dto->startYear,
                'end_year' => $dto->endYear,
                'candidate_id' => $candidate->id,
                'description' => $dto->description,
            ];

            Education::create($data);

            logActivity("Added education to candidate!", "к $candidate->first_name $candidate->last_name $candidate->patronymic присоединилось обучение в $dto->title $dto->degree $dto->specialty!");

            return static::toResponse(
                message: 'Education added!'
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Candidate Not Found', 404);
        }
    }
}
