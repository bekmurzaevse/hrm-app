<?php

namespace App\Dto\v1\Selection\Status;

use App\Http\Requests\v1\Selection\Status\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public string $title,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Selection\Status\UpdateRequest $request
     * @return StoreDto
     */
    public static function from(UpdateRequest $request): self
    {
        return new self(
            title: $request->input('title'),
        );
    }
}
