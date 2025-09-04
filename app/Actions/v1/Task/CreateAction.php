<?php

namespace App\Actions\v1\Task;

use App\Http\Requests\v1\Task\CreateDto;
use App\Models\Task;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction 
{
    use ResponseTrait;

    public function __invoke(CreateDto $dto): JsonResponse
    {
        $data = [
            'title' => $dto->title,
            'description' => $dto->description,
            'deadline' => $dto->deadline,
            'created_by' => $dto->createdBy,
            'status' => $dto->status,
            'priority' => $dto->priority,
        ];

        Task::create($data);

        return static::toResponse(
            message: 'Successfully created',
        );
    }
}