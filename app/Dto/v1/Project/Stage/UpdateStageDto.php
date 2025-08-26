<?php

namespace App\Dto\v1\Project\Stage;

use App\Http\Requests\v1\Project\Stage\UpdateStageRequest;

readonly class UpdateStageDto
{
    public function __construct(
        public string $title,
        public ?string $description,
        public int $executorId,
        public string $deadline
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\Stage\UpdateStageRequest $request
     * @return UpdateStageDto
     */
    public static function from(UpdateStageRequest $request): self
    {
        return new self(
            title: $request->title,
            description: $request->description,
            executorId: $request->executor_id,
            deadline: $request->deadline
        );
    }
}
