<?php

namespace App\Actions\v1\Project\StageTask;

use App\Dto\v1\Project\StageTask\UpdateStageTaskDto;
use App\Exceptions\ApiResponseException;
use App\Models\Stage;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateStageTaskAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $taskId
     * @param \App\Dto\v1\Project\StageTask\UpdateStageTaskDto $dto
     * @return JsonResponse
     *@throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $taskId, UpdateStageTaskDto $dto): JsonResponse
    {
        try {
            $stage = Stage::findOrFail($dto->stageId);

            $data = [
                'title' => $dto->title,
                'description' => $dto->description,
                'executor_id' => $dto->executorId,
                'priority' => $dto->priority,
                'deadline' => $dto->deadline,
                'created_by' => auth()->user()->id,
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
