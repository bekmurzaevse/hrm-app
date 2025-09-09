<?php

namespace App\Dto\v1\Task\Complete;

use App\Http\Requests\v1\Task\Complete\CompleteRequest;

readonly class CompleteDto
{
    public function __construct(
        public int $taskId,
        public string $comment
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Task\Complete\CompleteRequest $request
     * @return CompleteDto
     */
    public static function from(CompleteRequest $request): self
    {
        return new self(
            taskId: $request->task_id,
            comment: $request->comment,
        );
    }


}
