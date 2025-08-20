<?php

namespace App\Dto\Project;

use App\Http\Requests\v1\Project\UpdateStageTaskRequest;

readonly class UpdateStageTaskDto
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
     * @param \App\Http\Requests\v1\Project\UpdateStageTaskRequest $request
     * @return UpdateStageTaskDto
     */
    public static function from(UpdateStageTaskRequest $request): self
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
