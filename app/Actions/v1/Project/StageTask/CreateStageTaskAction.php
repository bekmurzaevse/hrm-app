<?php

namespace App\Actions\v1\Project\StageTask;

use App\Dto\v1\Project\StageTask\CreateStageTaskDto;
use App\Exceptions\ApiResponseException;
use App\Models\Stage;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CreateStageTaskAction
{
    use ResponseTrait;

    public function __invoke(CreateStageTaskDto $dto): JsonResponse
    {
        try {
            $stage = Stage::findOrFail($dto->stageId);

            $data = [
                'title' => $dto->title,
                'description' => $dto->description,
                'executor_id' => $dto->executorId,
                'priority' => $dto->priority,
                'deadline' => $dto->deadline,
                'created_by' => 1, // TODO: Replace with authenticated user ID
            ];
            $stage->stageTasks()->create($data);

            // Log user activity
            $title = 'Создание задачи';
            $text = "Задача «{$dto->title}» была создана в этапе «{$stage->title}» проекта «{$stage->project->title}»";
            logActivity($title, $text);

            return static::toResponse(
                message: "Stage's task created"
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException("Stage Not Found", 404);
        }
    }
}
