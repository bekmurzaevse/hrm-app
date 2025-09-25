<?php

namespace App\Actions\v1\Project\Stage\Task;

use App\Dto\v1\Project\Stage\Task\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Models\Stage;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $taskId
     * @param \App\Dto\v1\Project\Stage\Task\UpdateDto $dto
     * @return JsonResponse
     * @throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $taskId, UpdateDto $dto): JsonResponse
    {
        try {
            $stage = Stage::findOrFail($dto->stageId);

            $data = [
                'title' => $dto->title,
                'description' => $dto->description,
                'executor_id' => $dto->executorId,
                'priority' => $dto->priority,
                'deadline' => $dto->deadline,
                'created_by' => auth()->id(),
            ];

            // Log user activity
            $title = 'Обновление задачи';
            $text = "Задача «{$dto->title}» была обновлена в этапе «{$stage->title}» проекта «{$stage->project->title}»";
            logActivity($title, $text);

            $stage->stageTasks()->findOrFail($taskId)->update($data);

            return static::toResponse(
                message: "Stage's task updated"
            );
        } catch (ModelNotFoundException $e) {
            $model = class_basename($e->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
