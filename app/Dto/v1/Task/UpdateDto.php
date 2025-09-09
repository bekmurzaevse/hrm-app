<?php

namespace App\Dto\v1\Task;

use App\Http\Requests\v1\Task\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public string $title,
        public ?string $description,
        public ?string $deadline,
        public ?int $created_by,
        public string $status,
        public ?string $priority,
        public ?string $comment,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Task\UpdateRequest $request
     * @return UpdateDto
     */
    public static function from(UpdateRequest $request): self
    {
        return new self(
            title: $request->title,
            description: $request->description,
            deadline: $request->deadline,
            created_by: $request->created_by,
            status: $request->status,
            priority: $request->priority,
            comment: $request->comment,
        );
    }
}