<?php

namespace App\Actions\v1\Task\Accept;

use App\Enums\Task\TaskHistoryType;
use App\Exceptions\ApiResponseException;
use App\Models\TaskHistory;
use App\Models\TaskUser;
use App\Traits\ClearCache;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class AcceptAction
{
    use ResponseTrait, ClearCache;

    /**
     * Summary of __invoke
     * @param int $taskId
     * @return JsonResponse
     * @throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $taskId): JsonResponse
    {
        try {
            $executor = TaskUser::where('task_id', $taskId)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            if ($executor->accepted_at) {
                return static::toResponse(message: 'Задача уже принята');
            }

            $executor->update(['accepted_at' => now()]);

            $this->clear([
                'tasks',
            ]);

            TaskHistory::create([
                'task_id' => $taskId,
                'type' => TaskHistoryType::TaskAccepted,
                'changed_by' => auth()->id(),
                'comment' => 'Задача принята исполнителем',
            ]);

            logActivity('Task Accepted', "Задача принята: {$taskId}");

            return static::toResponse(message: 'Задача успешно принята');
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Ошибка при принятии задачи', 500);
        }
    }
}