<?php

namespace App\Dto\v1\TaskUser;

use App\Http\Requests\v1\TaskUser\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public ?int $task_id,
        public ?string $assigned_at,
        public ?string $status,
    ) {
    }

    public static function from(UpdateRequest $request): self
    {
        return new self(
            task_id: $request->task_id,
            assigned_at: $request->assigned_at,
            status: $request->status,
        );
    }
}