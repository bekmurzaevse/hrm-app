<?php

namespace App\Actions\v1\Task\Executor;

use App\Dto\v1\Task\Executor\AddDto;
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

class AddExecutorAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Task\Executor\AddDto $dto
     * @return JsonResponse
     * @throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(AddDto $dto): JsonResponse
    {
        try {
            $taskId = $dto->task_id;
            $userId = $dto->user_id;

            $task = Task::findOrFail($taskId);
            $user = User::findOrFail($userId);

            $exists = TaskUser::where('task_id', $task->id)
                ->where('user_id', $user->id)
                ->exists();

            if ($exists) {
                return static::toResponse(
                    message: 'Пользователь уже является исполнителем задачи',
                );
            }

            DB::transaction(function () use ($task, $user, $dto) {
                TaskUser::create([
                    'task_id' => $task->id,
                    'user_id' => $user->id,
                    'status' => TaskStatusEnum::OPEN->value,
                ]);

                TaskHistory::create([
                    'task_id'    => $task->id,
                    'changed_by' => auth()->id(),
                    'type'       => TaskHistoryType::ExecutorAdded,
                    'comment'    => "Добавлен исполнитель (ID: {$user->id})"
                        . ($dto->comment ? ". Комментарий: {$dto->comment}" : ''),
                ]);

                $initiator = auth()->user();
                logActivity(
                    "Добавлен исполнитель",
                    "Задача '{$task->title}' — {$user->first_name} {$user->last_name} добавлен инициатором {$initiator->first_name} {$initiator->last_name}"
                    . ($dto->comment ? " — {$dto->comment}" : '')
                );

            });

            return static::toResponse(
                message: 'Исполнитель успешно добавлен'
            );

        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task or User not found', 404);
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Server Error', 500);
        }
    }
}