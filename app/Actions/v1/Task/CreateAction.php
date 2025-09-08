<?php

namespace App\Actions\v1\Task;

use App\Dto\v1\Task\CreateDto;
use App\Models\Task;
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
        ];

        $task = Task::create($data);

        logActivity(
            "Создана задача",
            "Задача '{$task->title}' создана пользователем {$task->createdBy->first_name} {$task->createdBy->last_name}"
        );

        return static::toResponse(
            message: 'Successfully created',
        );
    }
}