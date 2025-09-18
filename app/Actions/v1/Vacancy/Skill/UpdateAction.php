<?php

namespace App\Actions\v1\Vacancy\Skill;

use App\Dto\v1\Vacancy\Skill\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param int $skillId
     * @param \App\Dto\v1\Vacancy\Skill\UpdateDto $dto
     * @return JsonResponse
     *@throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $id, int $skillId, UpdateDto $dto): JsonResponse
    {
        try {
            $vacancy = Vacancy::findOrFail($id);

            $vacancy->skills()->findOrFail($skillId)
                ->update(['title' => $dto->title]);

            // Log user activity
            $title = 'Обновление навыка';
            $text = "Навык был обновлен в вакансии «{$vacancy->title}».";
            logActivity($title, $text);

            return static::toResponse(
                message: "Vacancy's Skill Updated"
            );
        } catch (ModelNotFoundException $e) {
            $model = class_basename($e->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
