<?php

namespace App\Dto\v1\Selection\SelectionStatus;

use App\Http\Requests\v1\Selection\SelectionStatus\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public string $title,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Selection\SelectionStatus\UpdateRequest $request
     * @return StoreDto
     */
    public static function from(UpdateRequest $request): self
    {
        return new self(
            title: $request->input('title'),
        );
    }
}
