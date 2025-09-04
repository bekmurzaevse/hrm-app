<?php

namespace App\Http\Requests\v1\Task;

readonly class CreateDto
{
    public function __construct(
        public string $title,
        public ?string $description,
        public string $deadline,
        public int $createdBy,
        public string $status,
        public string $priority,
    ) {
    }

    public static function from(CreateRequest $request): self
    {
        return new self(
            title: $request->title,
            description: $request->description,
            deadline: $request->deadline,
            createdBy: $request->created_by,
            status: $request->status,
            priority: $request->priority,
        );
    }
}