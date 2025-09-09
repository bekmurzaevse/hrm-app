<?php

namespace App\Dto\v1\Selection;

use App\Http\Requests\v1\Selection\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public string $title,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Selection\CreateRequest $request
     * @return CreateDto
     */
    public static function from(CreateRequest $request): self
    {
        return new self(
            title: $request->input('title'),
        );
    }
}
