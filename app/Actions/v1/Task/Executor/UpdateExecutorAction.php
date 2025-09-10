<?php

namespace App\Actions\v1\Task\Executor;

use App\Dto\v1\Task\Executor\UpdateExecutorDto;
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

class UpdateExecutorAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Task\Executor\UpdateExecutorDto $dto
     * @return JsonResponse
     * @throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(UpdateExecutorDto $dto): JsonResponse
    {
        try {
            $taskId = $dto->task_id;
            $oldUserId = $dto->old_user_id;
            $newUserId = $dto->new_user_id;

            $task = Task::findOrFail($taskId);
            $oldUser = User::findOrFail($oldUserId);
            $newUser = User::findOrFail($newUserId);

            $oldExecutor = TaskUser::where('task_id', $taskId)
                ->where('user_id', $oldUserId)
                ->first();

            if (!$oldExecutor) {
                throw new ModelNotFoundException();
            }

            DB::transaction(function () use ($taskId, $newUserId, $dto, $oldUserId, $newUser) {
                TaskUser::firstOrCreate(
                    [
                        'task_id' => $taskId,
                        'user_id' => $newUserId,
                    ],
                    [
                        'status' => TaskStatusEnum::OPEN->value,
                    ]
                );

                TaskHistory::create([
                    'task_id' => $taskId,
                    'changed_by' => auth()->id(),
                    'type' => 'executor_changed',
                    'comment' => "Исполнитель изменен: {$oldUserId} → {$newUserId}"
                        . ($dto->comment ? ". Комментарий: {$dto->comment}" : ''),
                ]);
            });

            return static::toResponse(
                message: 'Исполнитель успешно обновлен'
            );

        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task or Old Executor not found', 404);
        } catch (\Exception $ex) {
            throw new ApiResponseException('Server Error', 500);
        }
    }
}