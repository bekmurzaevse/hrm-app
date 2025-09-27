<?php

namespace App\Dto\v1\Task\Transfer;

use App\Http\Requests\v1\Task\Transfer\TransferRequest;

readonly class TransferDto
{
    public function __construct(
        public int $task_id,
        public int $user_id,
        public string $comment,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Task\Transfer\TransferRequest $request
     * @return TransferDto
     */
    public static function from(TransferRequest $request): self
    {
        return new self(
            task_id: (int)$request->route('id'),
            user_id: $request->user_id,
            comment: $request->comment,
        );
    }
}