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
            stageId: $request->input('stage_id'),
            title: $request->input('title'),
            description: $request->input('description'),
            executorId: $request->input('executor_id'),
            priority: $request->input('priority'),
            deadline: $request->input('deadline')
        );
    }
}
