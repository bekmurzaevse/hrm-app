<?php

namespace App\Actions\v1\Project;

use App\Dto\v1\Project\UpdatePerformersDto;
use App\Exceptions\ApiResponseException;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdatePerformersAction
{
    use ResponseTrait;


    public function __invoke(int $id, UpdatePerformersDto $dto): JsonResponse
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
