<?php

namespace App\Actions\v1\Project;

use App\Dto\v1\Project\UpdateExecutorDto;
use App\Exceptions\ApiResponseException;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateExecutorAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\v1\Project\UpdateExecutorDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, UpdateExecutorDto $dto): JsonResponse
    {
        try {
            $project = Project::findOrFail($id);

            // Log user activity
            $title = 'Обновил исполнителей';
            $text = "Исполнители проекта «{$project->title}» были обновлены.";
            logActivity($title, $text);

            $project->update([
                'executor_id' => $dto->executorId
            ]);
            return static::toResponse(
                message: 'Executor updated successfully for project'
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Project not found', 404);
        }
    }
}
