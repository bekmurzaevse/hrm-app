<?php

namespace App\Dto\v1\Type;

use App\Http\Requests\v1\Type\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public string $title,
        public ?string $description,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Type\UpdateRequest $request
     * @return UpdateDto
     */
    public static function from(UpdateRequest $request): self
    {
        return new self(
            title: $request->input('title'),
            description: $request->input('description'),
        );
    }
}
