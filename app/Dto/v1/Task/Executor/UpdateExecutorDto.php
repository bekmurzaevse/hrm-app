<?php

namespace App\Dto\v1\Task\Executor;

use App\Http\Requests\v1\Task\Executor\UpdateExecutorRequest;

readonly class UpdateExecutorDto
{
    public function __construct(
        public int $task_id,
        public int $old_user_id,
        public int $new_user_id,
        public ?string $comment,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Task\Executor\UpdateExecutorRequest $request
     * @return UpdateExecutorDto
     */
    public static function from(UpdateExecutorRequest $request): self
    {
        return new self(
            task_id: (int) $request->route('id'),
            old_user_id: $request->old_user_id,
            new_user_id: $request->new_user_id,
            comment: $request->comment,
        );
    }
}