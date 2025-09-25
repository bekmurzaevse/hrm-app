<?php

namespace App\Actions\v1\Task\Complete;

use App\Dto\v1\Task\Complete\CompleteDto;
use App\Enums\Task\TaskHistoryType;
use App\Enums\Task\TaskStatusEnum;
use App\Exceptions\ApiResponseException;
use App\Models\Task;
use App\Models\TaskHistory;
use App\Models\TaskUser;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CompleteAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Task\Complete\CompleteDto $dto
     * @return JsonResponse
     * @throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(CompleteDto $dto): JsonResponse
    {
        try {
            $userId = auth()->user()->id;

            $taskUser = TaskUser::where('task_id', $dto->taskId)
                ->where('user_id', $userId)
                ->firstOrFail();

            if (!$taskUser->accepted_at) {
                throw new ApiResponseException('Вы не приняли задачу. Сначала нажмите «Принять».', 403);
            }

            $taskUser->update([
                'status' => TaskStatusEnum::COMPLETED,
            ]);

            TaskHistory::create([
                'task_id' => $dto->taskId,
                'type' => TaskHistoryType::TaskCompleted,
                'changed_by' => $userId,
                'comment' => "Задача выполнена. Комментарий: {$dto->comment}",
            ]);

            $incomplete = TaskUser::where('task_id', $dto->taskId)
                ->where('status', '!=', TaskStatusEnum::COMPLETED)
                ->exists();

            if (!$incomplete) {
                Task::where('id', $dto->taskId)->update([
                    'status' => TaskStatusEnum::COMPLETED,
                ]);
            }

            $task = Task::findOrFail($dto->taskId);
            $user = auth()->user();
            $userName = $user->first_name . ' ' . $user->last_name;

            logActivity(
                "Задача выполнена!",
                "Задача '{$task->title}' (ID: {$task->id}) была отмечена как выполненная пользователем {$userName}"
            );

            return static::toResponse(
                message: 'Задача отмечена как выполненная'
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task User Not Found', 404);
        }
    }
}

