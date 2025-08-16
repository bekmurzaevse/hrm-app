<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\AddEducationDto;
use App\Models\Education;
use App\Traits\ResponseTrait;
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
        $data = [
            'title' => $dto->title,
            'degree' => $dto->degree,
            'specialty' => $dto->specialty,
            'start_year' => $dto->startYear,
            'end_year' => $dto->endYear,
            'candidate_id' => $id,
            'description' => $dto->description,
        ];

        Education::create($data);

        return static::toResponse(
            message: 'Education added!'
        );
    }
}
