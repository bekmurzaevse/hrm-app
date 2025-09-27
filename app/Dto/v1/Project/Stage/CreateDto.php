<?php

namespace App\Dto\v1\Project\Stage;

use App\Http\Requests\v1\Project\Stage\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public ?int $stageId,
        public string $title,
        public ?string $description,
        public int $executorId,
        public string $deadline
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\Stage\CreateRequest $request
     * @return CreateDto
     */
    public static function from(CreateRequest $request): self
    {
        return new self(
            stageId: $request->input('stage_id'),
            title: $request->input('title'),
            description: $request->input('description'),
            executorId: $request->input('executor_id'),
            deadline: $request->input('deadline')
        );
    }
}
