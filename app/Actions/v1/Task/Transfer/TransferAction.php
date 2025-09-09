<?php

namespace App\Actions\v1\Task\Transfer;

use App\Dto\v1\Task\Transfer\TransferDto;
use App\Exceptions\ApiResponseException;
use App\Http\Resources\v1\Task\TaskHistoryResource;
use App\Models\Task;
use App\Models\TaskHistory;
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
            $task = Task::findOrFail($dto->task_id);
            $user = User::findOrFail($dto->user_id);

            DB::transaction(function () use ($task, $dto) {
                $task->update([
                    'executor_id' => $dto->user_id,
                ]);

                TaskHistory::create([
                    'task_id'    => $task->id,
                    'changed_by' => auth()->id(),
                    'type'       => 'task_sent',
                    'comment'    => "Задача отправлена пользователю (ID: {$dto->user_id})"
                        . ($dto->comment ? ". Комментарий: {$dto->comment}" : ''),
                ]);
            });

            return static::toResponse(
                message: 'Задача успешно отправлена',
            );

        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task or User not found', 404);
        } catch (\Exception $ex) {
            throw new ApiResponseException('Server Error', 500);
        }
    }
}