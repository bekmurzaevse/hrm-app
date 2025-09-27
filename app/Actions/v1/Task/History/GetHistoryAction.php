<?php

namespace App\Actions\v1\Task\History;

use App\Exceptions\ApiResponseException;
use App\Http\Resources\v1\Task\TaskHistoryResource;
use App\Models\Task;
use App\Models\TaskUser;
use App\Traits\ResponseTrait;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetHistoryAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $taskId
     * @return AnonymousResourceCollection
     */
    public function __invoke(int $taskId): AnonymousResourceCollection
    {
        $task = Task::findOrFail($taskId);
        $user = auth()->user();

        $belongsToUser = $task->created_by === $user->id
            || TaskUser::where('task_id', $task->id)->where('user_id', $user->id)->exists();

        if (!$belongsToUser) {
            throw new ApiResponseException('Вы не можете просматривать историю чужой задачи', 403);
        }

        $history = $task->history()
            ->with('changedBy')
            ->latest()
            ->get();

        return TaskHistoryResource::collection($history);
    }
}