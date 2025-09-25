<?php

namespace App\Dto\v1\Task;

use App\Http\Requests\v1\Task\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public string $title,
        public ?string $description,
        public string $deadline,
        public string $priority,
        public ?string $comment,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Task\CreateRequest $request
     * @return CreateDto
     */
    public static function from(CreateRequest $request): self
    {
        return new self(
            title: $request->title,
            description: $request->description,
            deadline: $request->deadline,
            priority: $request->priority,
            comment: $request->comment,
        );
    }
}