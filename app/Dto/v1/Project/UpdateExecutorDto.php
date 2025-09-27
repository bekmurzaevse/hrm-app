<?php

namespace App\Dto\v1\Project;

use App\Http\Requests\v1\Project\UpdateExecutorRequest;


readonly class UpdateExecutorDto
{
    public function __construct(
        public int $executorId
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\UpdateExecutorRequest $request
     * @return UpdateExecutorDto
     */
    public static function from(UpdateExecutorRequest $request): self
    {
        return new self(
            executorId: $request->input('executor_id'),
        );
    }
}
