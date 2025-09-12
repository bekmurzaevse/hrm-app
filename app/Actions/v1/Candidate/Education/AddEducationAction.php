<?php

namespace App\Actions\v1\Candidate\Education;

use App\Dto\v1\Candidate\Education\AddEducationDto;
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
     * @param \App\Dto\v1\Candidate\Education\AddEducationDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, AddEducationDto $dto): JsonResponse
    {
        try {
            $candidate = Candidate::findOrFail($id);
            $data = [
                'title' => $dto->title,
                'degree' => $dto->degree,
                'specialty' => $dto->specialty,
                'start_year' => $dto->startYear,
                'end_year' => $dto->endYear,
                'candidate_id' => $candidate->id,
                'description' => $dto->description,
            ];

            $education = Education::create($data);

            logActivity(
                "Добавлено образование кандидату",
                "Кандидату {$candidate->first_name} {$candidate->last_name} $candidate->first_name $candidate->first_name добавлено образование: {$education->title}, степень: {$education->degree->value}, специальность: {$education->specialty}, годы: {$education->start_year}-{$education->end_year}. Файл: " . __FILE__
            );

            return static::toResponse(
                message: 'Education added!'
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Candidate Not Found', 404);
        }
    }
}
