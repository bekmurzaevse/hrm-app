<?php

namespace App\Dto\v1\Task\Reject;

use App\Http\Requests\v1\Task\Reject\RejectRequest;

readonly class RejectDto
{
    public function __construct(
        public int $taskId,
        public string $comment,
    ) {}

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Task\Reject\RejectRequest $request
     * @return RejectDto
     */
    public static function from(RejectRequest $request): self
    {
        return new self(
            taskId: (int) $request->route('id'),
            comment: $request->comment,
        );
    }
}
