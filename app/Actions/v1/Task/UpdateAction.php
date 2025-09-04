<?php

namespace App\Actions\v1\Task;

use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\ApiResponseException;
use App\Http\Resources\v1\Task\TaskResource;
use App\Dto\v1\Task\UpdateDto;
use App\Models\Task;
use App\Traits\ResponseTrait;

class UpdateAction 
{
    use ResponseTrait;

    public function __invoke(int $id, UpdateDto $dto): JsonResponse
    {
        try {
            $task = Task::with(['createdBy'])->findOrFail($id);
            $task->update([
                'title' => $dto->title,
                'description' => $dto->description ?? $task->description,
                'deadline' => $dto->deadline ?? $task->deadline,
                'created_by' => $dto->createdBy ?? $task->created_by,
                'status' => $dto->status,
                'priority' => $dto->priority ?? $task->priority,
            ]);

            return static::toResponse(
                message: "$id - id li task janalandi",
                data: new TaskResource($task)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task Not Found', 404);
        }
    }
}