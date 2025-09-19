<?php

namespace App\Dto\v1\Project\Stage\Task;

use App\Http\Requests\v1\Project\Stage\Task\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public int $stageId,
        public string $title,
        public ?string $description,
        public int $executorId,
        public string $priority,
        public string $deadline
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\Stage\Task\CreateRequest $request
     * @return CreateDto
     */
    public static function from(CreateRequest $request): self
    {
        return new self(
            stageId: $request->stage_id,
            title: $request->title,
            description: $request->description,
            executorId: $request->executor_id,
            priority: $request->priority,
            deadline: $request->deadline
        );
    }
}
