<?php

namespace App\Actions\v1\Vacancy;

use App\Exceptions\ApiResponseException;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteSkillAction
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
            Vacancy::findOrFail($id)->skills()->findOrFail($skillId)->delete();

            return static::toResponse(
                message: "Id-{$skillId} skill deleted",
            );
        } catch (ModelNotFoundException $ex) {
            $model = class_basename($ex->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
