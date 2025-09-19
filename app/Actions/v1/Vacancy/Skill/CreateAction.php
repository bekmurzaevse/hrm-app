<?php

namespace App\Actions\v1\Vacancy\Skill;

use App\Dto\v1\Vacancy\Skill\CreateDto;
use App\Exceptions\ApiResponseException;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Vacancy\Skill\CreateDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, CreateDto $dto): JsonResponse
    {
        try {
            $vacancy = Vacancy::findOrFail($id);

            // Log user activity
            $title = 'Создание навыка';
            $text = "Навык был добавлен к вакансии «{$vacancy->title}».";
            logActivity($title, $text);

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
