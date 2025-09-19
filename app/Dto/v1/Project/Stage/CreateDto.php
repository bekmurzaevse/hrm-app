<?php

namespace App\Dto\v1\Project\Stage;

use App\Http\Requests\v1\Project\Stage\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public int $stageId,
        public string $title,
        public ?string $description,
        public int $executorId,
        public string $deadline
    ) {
    }


    public static function from(CreateRequest $request): self
    {
        return new self(
            stageId: $request->stage_id,
            title: $request->title,
            description: $request->description,
            executorId: $request->executor_id,
            deadline: $request->deadline
        );
    }
}
