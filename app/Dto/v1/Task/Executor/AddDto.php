<?php

namespace App\Dto\v1\Task\Executor;

use App\Http\Requests\v1\Task\Executor\AddRequest;

readonly class AddDto
{
    public function __construct(
        public int $task_id,
        public int $user_id,
        public ?string $comment,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Task\Executor\AddRequest $request
     * @return AddDto
     */
    public static function from(AddRequest $request): self
    {
        return new self(
            task_id: (int) $request->route('id'),
            user_id: $request->user_id,
            comment: $request->comment,
        );
    }
}