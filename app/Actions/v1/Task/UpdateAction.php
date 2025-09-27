<?php

namespace App\Actions\v1\Task;

use App\Enums\Task\TaskHistoryType;
use App\Models\TaskHistory;
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
            $user = auth()->user();

            $task->update([
                'title' => $dto->title,
                'description' => $dto->description ?? $task->description,
                'deadline' => $dto->deadline ?? $task->deadline,
                'created_by' => $dto->created_by ?? $task->created_by,
                'status' => $dto->status,
                'priority' => $dto->priority ?? $task->priority,
                'comment' => $dto->comment ?? $task->comment,
            ]);

            TaskHistory::create([
                'task_id'    => $task->id,
                'changed_by' => $user->id,
                'type'       => TaskHistoryType::TaskUpdated,
                'comment'    => "Задача обновлена пользователем ID: " . $user->id,
            ]);

            logActivity(
                "Задача обновлена!",
                "Задача '{$task->title}' (ID: {$task->id}) была обновлена пользователем " . $user->first_name . ' ' . $user->last_name
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