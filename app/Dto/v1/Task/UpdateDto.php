<?php

namespace App\Dto\v1\Task;

use App\Http\Requests\v1\Task\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public string $title,
        public ?string $description,
        public ?string $deadline,
        public string $status,
        public ?string $priority,
    ) {
    }

    public static function from(UpdateRequest $request): self
    {
        return new self(
            title: $request->title,
            description: $request->description,
            deadline: $request->deadline,
            status: $request->status,
            priority: $request->priority,
        );
    }
}