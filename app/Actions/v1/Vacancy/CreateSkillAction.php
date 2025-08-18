<?php

namespace App\Actions\v1\Vacancy;

use App\Dto\Vacancy\CreateSkillDto;
use App\Exceptions\ApiResponseException;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CreateSkillAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Vacancy\CreateSkillDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, CreateSkillDto $dto): JsonResponse
    {
        try {
            $vacancy = Vacancy::findOrFail($id);

            $vacancy->skills()->createMany(
                array_map(fn($title) => ['title' => $title], $dto->titles)
            );

            return static::toResponse(
                message: "Vacancy's skills created"
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Vacancy not found', 404);
        }
    }
}
