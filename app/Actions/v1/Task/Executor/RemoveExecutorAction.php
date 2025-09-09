<?php

namespace App\Actions\v1\Task\Executor;

use App\Dto\v1\Task\Executor\RemoveExecutorDto;
use App\Exceptions\ApiResponseException;
use App\Models\Task;
use App\Models\TaskHistory;
use App\Models\TaskUser;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RemoveExecutorAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Task\Executor\RemoveExecutorDto $dto
     * @return JsonResponse
     * @throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(RemoveExecutorDto $dto): JsonResponse
    {
        try {
            $taskId = $dto->task_id;
            $userId = $dto->user_id;

            $task = Task::findOrFail($taskId);
            $user = User::findOrFail($userId);

            $taskUser = TaskUser::where('task_id', $taskId)
                ->where('user_id', $userId)
                ->first();

            if (!$taskUser) {
                throw new ModelNotFoundException();
            }

            DB::transaction(function () use ($taskUser, $dto, $taskId, $userId) {
                $taskUser->delete();

                TaskHistory::create([
                    'task_id'    => $taskId,
                    'changed_by' => auth()->id(),
                    'type'       => 'executor_removed',
                    'comment'    => "Исполнитель удален (ID: {$userId})"
                        . ($dto->comment ? ". Комментарий: {$dto->comment}" : ''),
                ]);
            });

            return static::toResponse(
                message: 'Исполнитель успешно удален'
            );

        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task or Executor not found', 404);
        } catch (\Exception $ex) {
            throw new ApiResponseException('Server Error', 500);
        }
    }
} 