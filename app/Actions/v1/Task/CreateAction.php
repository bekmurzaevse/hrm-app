<?php

namespace App\Actions\v1\Task;

use App\Dto\v1\Task\CreateDto;
use App\Enums\Task\TaskHistoryType;
use App\Models\Task;
use App\Models\TaskHistory;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction 
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Task\CreateDto $dto
     * @return JsonResponse
     */
    public function __invoke(CreateDto $dto): JsonResponse
    {
        $data = [
            'title' => $dto->title,
            'description' => $dto->description,
            'deadline' => $dto->deadline,
            'created_by' => auth()->user()->id,
            'status' => $dto->status,
            'priority' => $dto->priority,
            'comment' => $dto->comment,
        ];

        $task = Task::create($data);

        TaskHistory::create([
            'task_id'    => $task->id,
            'changed_by' => auth()->id(),
            'type'       => TaskHistoryType::TaskCreated,
            'comment'    => "Задача создана пользователем ID: " . auth()->id(),
        ]);

        logActivity(
            "Создана задача",
            "Задача '{$task->title}' создана пользователем {$task->createdBy->first_name} {$task->createdBy->last_name}"
        );

        return static::toResponse(
            message: 'Successfully created',
        );
    }
}