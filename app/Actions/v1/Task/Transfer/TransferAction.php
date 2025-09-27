<?php

namespace App\Actions\v1\Task\Transfer;

use App\Dto\v1\Task\Transfer\TransferDto;
use App\Enums\Task\TaskHistoryType;
use App\Enums\Task\TaskStatusEnum;
use App\Exceptions\ApiResponseException;
use App\Models\Task;
use App\Models\TaskHistory;
use App\Models\TaskUser;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TransferAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param TransferDto $dto
     * @return JsonResponse
     * @throws ApiResponseException
     */
    public function __invoke(TransferDto $dto): JsonResponse
    {
        try {
            $currentUser = auth()->user();
            $task = Task::findOrFail($dto->task_id);
            $newUser = User::findOrFail($dto->user_id);

            $belongsToUser = $task->created_by === $currentUser->id
                || TaskUser::where('task_id', $task->id)->where('user_id', $currentUser->id)->exists();

            if (!$belongsToUser) {
                throw new ApiResponseException('Вы не можете передавать чужую задачу', 403);
            }

            if (empty($dto->comment)) {
                throw new ApiResponseException('Комментарий обязателен при передаче задачи', 422);
            }

            DB::transaction(function () use ($task, $newUser, $currentUser, $dto) {
                TaskUser::create([
                    'task_id' => $task->id,
                    'user_id' => $newUser->id,
                    'status' => TaskStatusEnum::OPEN,
                ]);

                TaskHistory::create([
                    'task_id' => $task->id,
                    'changed_by' => $currentUser->id,
                    'type' => TaskHistoryType::TaskSent,
                    'comment' => "Задача отправлена пользователю (ID: {$newUser->id})"
                        . ($dto->comment ? ". Комментарий: {$dto->comment}" : ''),
                ]);

                logActivity(
                    "Передача задачи",
                    "{$task->title} → {$newUser->first_name} {$newUser->last_name}" . ($dto->comment ? " — {$dto->comment}" : '')
                );

            });

            return static::toResponse(
                message: 'Задача успешно отправлена',
            );

        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task or User not found', 403);
        }
    }
}