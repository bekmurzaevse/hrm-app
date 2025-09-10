<?php

namespace App\Actions\v1\Task\Reject;

use App\Dto\v1\Task\Reject\RejectDto;
use App\Enums\Task\TaskHistoryType;
use App\Models\Task;
use App\Models\TaskHistory;
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
            $task = Task::findOrFail($dto->taskId);

            $task->update([
                'status' => 'rejected',
            ]);

            TaskHistory::create([
                'task_id'    => $task->id,
                'changed_by' => auth()->id(),
                'type'       => TaskHistoryType::TaskRejected,
                'comment'    => $dto->comment,
            ]);

            return static::toResponse(message: 'Задача отклонена');
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task not found', 404);
        } catch (\Exception $ex) {
            throw new ApiResponseException('Server Error', 500);
        }
    }
}