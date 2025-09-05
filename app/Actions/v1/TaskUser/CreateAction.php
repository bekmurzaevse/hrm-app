<?php

namespace App\Actions\v1\TaskUser;

use App\Dto\v1\TaskUser\CreateDto;
use App\Models\TaskUser;
use App\Traits\ResponseTrait;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\TaskUser\CreateDto $dto
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(CreateDto $dto)
    {
        $data = [
            'task_id' => $dto->task_id,
            'user_id' => auth()->user()->id,
            'assigned_at' => now(),
            'status' => $dto->status,
        ];

        TaskUser::create($data);

        logActivity(
            "Назначен пользователь на задачу",
            "Пользователь " . auth()->user()->first_name . ' ' . auth()->user()->last_name . " назначен на задачу ID: {$dto->task_id}"
        );

        return static::toResponse(
            message: 'Task User created successfully',
        );
    }
}