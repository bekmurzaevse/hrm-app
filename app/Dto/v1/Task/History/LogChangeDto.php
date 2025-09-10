<?php

namespace App\Dto\v1\Task\History;

use App\Http\Requests\v1\Task\History\LogChangeRequest;

readonly class LogChangeDto
{
    public function __construct(
        public int $task_id,
        public string $comment,
        public ?string $type,
    ) {}

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Task\History\LogChangeRequest $request
     * @return LogChangeDto
     */
    public static function from(LogChangeRequest $request): self
    {
        return new self(
            task_id: (int) $request->route('id'),
            comment: $request->comment,
            type: $request->type,
        );
    }
}