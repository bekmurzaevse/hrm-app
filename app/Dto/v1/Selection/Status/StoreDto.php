<?php

namespace App\Dto\v1\Selection\Status;

use App\Http\Requests\v1\Selection\Status\StoreRequest;

readonly class StoreDto
{
    public function __construct(
        public string $title,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Selection\Status\StoreRequest $request
     * @return StoreDto
     */
    public static function from(StoreRequest $request): self
    {
        return new self(
            title: $request->input('title'),
        );
    }
}
