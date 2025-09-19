<?php

namespace App\Actions\v1\Project\Stage\Task;

use App\Dto\v1\Project\Stage\Task\CreateDto;
use App\Exceptions\ApiResponseException;
use App\Models\Stage;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    public function __invoke(CreateDto $dto): JsonResponse
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
            $stage->stageTasks()->create($data);

            // Log user activity
            $title = 'Создание задачи';
            $text = "Задача «{$dto->title}» была создана в этапе «{$stage->title}» проекта «{$stage->project->title}»";
            logActivity($title, $text);

            return static::toResponse(
                code: 201,
                message: "Stage's task created"
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException("Stage Not Found", 404);
        }
    }
}
