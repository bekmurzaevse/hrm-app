<?php

namespace App\Actions\v1\Vacancy\Detail;

use App\Dto\Vacancy\Detail\ChangeDto;
use App\Exceptions\ApiResponseException;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ChangeAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Vacancy\Detail\ChangeDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, ChangeDto $dto): JsonResponse
    {
        try {
            $data = [
                'description' => $dto->description,
                'requirements' => $dto->requirements,
                'responsibilities' => $dto->responsibilities,
                'work_conditions' => $dto->workConditions,
                'benefits' => $dto->benefits,
            ];

            $vacancy = Vacancy::findOrFail($id);

            $vacancy->vacancyDetail()->updateOrCreate(
                ['vacancy_id' => $id],
                $data
            );

            return static::toResponse(
                message: "Vacancy's detail changed"
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Vacancy not found', 404);
        }

    }
}
