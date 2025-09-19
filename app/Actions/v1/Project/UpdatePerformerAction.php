<?php

namespace App\Actions\v1\Project;

use App\Dto\v1\Project\UpdatePerformerDto;
use App\Exceptions\ApiResponseException;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdatePerformerAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Project\UpdatePerformerDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, UpdatePerformerDto $dto): JsonResponse
    {
        try {
            $project = Project::findOrFail($id);

            // Log user activity
            $title = 'Обновил исполнителей';
            $text = "Исполнители проекта «{$project->title}» были обновлены.";
            logActivity($title, $text);

            $project->performers()->sync($dto->performers);

            return static::toResponse(
                message: 'Performers updated successfully for project'
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Project not found', 404);
        }
    }
}
