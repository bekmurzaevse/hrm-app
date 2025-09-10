<?php

namespace App\Actions\v1\Task\History;

use App\Dto\v1\Task\History\LogChangeDto;
use App\Models\Task;
use App\Models\TaskHistory;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class LogChangeAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Task\History\LogChangeDto $dto
     * @return JsonResponse
     */
    public function __invoke(LogChangeDto $dto): JsonResponse
    {
        $task = Task::findOrFail($dto->task_id);

        TaskHistory::create([
            'task_id'    => $task->id,
            'changed_by' => auth()->id(),
            'type'       => $dto->type,
            'comment'    => $dto->comment,
        ]);

        return static::toResponse(message: 'Изменение успешно зафиксировано');
    }
}
