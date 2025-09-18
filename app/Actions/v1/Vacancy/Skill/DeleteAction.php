<?php

namespace App\Actions\v1\Vacancy\Skill;

use App\Exceptions\ApiResponseException;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param int $skillId
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, int $skillId): JsonResponse
    {
        try {
            $vacancy = Vacancy::findOrFail($id);
            $vacancy->skills()->findOrFail($skillId)->delete();

            // Log user activity
            $title = 'Удаление навыка';
            $text = "Навык был удален из вакансии «{$vacancy->title}».";
            logActivity($title, $text);

            return static::toResponse(
                message: "Id-{$skillId} skill deleted",
            );
        } catch (ModelNotFoundException $ex) {
            $model = class_basename($ex->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
