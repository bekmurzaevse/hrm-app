<?php

namespace App\Actions\v1\Vacancy;

use App\Dto\Vacancy\UpdateSkillDto;
use App\Exceptions\ApiResponseException;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateSkillAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param int $skillId
     * @param \App\Dto\Vacancy\UpdateSkillDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, int $skillId, UpdateSkillDto $dto): JsonResponse
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
