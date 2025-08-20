<?php

namespace App\Dto\Project;

use App\Http\Requests\v1\Project\CreateStageTaskRequest;

readonly class CreateStageTaskDto
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
     * @param \App\Http\Requests\v1\Project\CreateStageTaskRequest $request
     * @return CreateStageTaskDto
     */
    public static function from(CreateStageTaskRequest $request): self
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
