<?php

namespace App\Actions\v1\Task\History;

use App\Http\Resources\v1\Task\TaskHistoryResource;
use App\Models\Task;
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

        $history = $task->history()
            ->with('changedBy')
            ->latest()
            ->get();

        return TaskHistoryResource::collection($history);
    }
}