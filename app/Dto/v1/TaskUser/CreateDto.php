<?php

namespace App\Dto\v1\TaskUser;

use App\Http\Requests\v1\TaskUser\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public int $task_id,
        public string $status,
    ) {
    }

    public static function from(CreateRequest $request): self
    {
        return new self(
            task_id: $request->task_id,
            status: $request->status,
        );
    }
}
