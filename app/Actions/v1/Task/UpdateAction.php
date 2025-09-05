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

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\v1\Task\UpdateDto $dto
     * @return JsonResponse
     * @throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $id, UpdateDto $dto): JsonResponse
    {
        try {
            $task = Task::with(['createdBy'])->findOrFail($id);
            $task->update([
                'title' => $dto->title,
                'description' => $dto->description ?? $task->description,
                'deadline' => $dto->deadline ?? $task->deadline,
                'created_by' => auth()->user()->id,
                'status' => $dto->status,
                'priority' => $dto->priority ?? $task->priority,
            ]);

            logActivity(
                "Задача обновлена!",
                "Задача '{$task->title}' (ID: {$task->id}) была обновлена пользователем"
                //auth()->user()->first_name . " " . auth()->user()->last_name
            );

            return static::toResponse(
                message: "$id - id li task jan'alandı",
                data: new TaskResource($task)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task Not Found', 404);
        }
    }
}