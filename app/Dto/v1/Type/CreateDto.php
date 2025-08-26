<?php

namespace App\Dto\v1\Type;

use App\Http\Requests\v1\Type\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public string $title,
        public ?string $description,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Type\CreateRequest $request
     * @return CreateDto
     */
    public static function from(CreateRequest $request): self
    {
        return new self(
            title: $request->title,
            description: $request->description,
        );
    }
}
