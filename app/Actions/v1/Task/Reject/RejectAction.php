<?php

namespace App\Actions\v1\Task\Reject;

use App\Dto\v1\Task\Reject\RejectDto;
use App\Enums\Task\TaskHistoryType;
use App\Enums\Task\TaskStatusEnum;
use App\Models\Task;
use App\Models\TaskHistory;
use App\Models\TaskUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTrait;
use App\Exceptions\ApiResponseException;

class RejectAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Task\Reject\RejectDto $dto
     * @return JsonResponse
     * @throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(RejectDto $dto): JsonResponse
    {
        try {
            $userId = auth()->id();

            $taskUser = TaskUser::where('task_id', $dto->taskId)
                ->where('user_id', $userId)
                ->firstOrFail();

            if (!$taskUser->accepted_at) {
                throw new ApiResponseException('Вы не приняли задачу. Сначала нажмите «Принять».', 403);
            }

            $taskUser->update([
                'status' => TaskStatusEnum::REJECTED->value,
            ]);

            TaskHistory::create([
                'task_id' => $dto->taskId,
                'changed_by' => $userId,
                'type' => TaskHistoryType::TaskRejected,
                'comment' => $dto->comment,
            ]);

            $task = Task::findOrFail($dto->taskId);
            $user = auth()->user();
            $userName = $user->first_name . ' ' . $user->last_name;

            logActivity(
                "Задача отклонена!",
                "Задача '{$task->title}' (ID: {$task->id}) была отклонена пользователем {$userName}"
            );

            return static::toResponse(message: 'Задача отклонена');
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task User Not Found', 404);
        }
    }
}