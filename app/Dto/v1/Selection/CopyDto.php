<?php

namespace App\Dto\v1\Selection;

use App\Http\Requests\v1\Selection\CopyRequest;

readonly class CopyDto
{
    public function __construct(
        public string $title,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Selection\CopyRequest $request
     * @return CopyDto
     */
    public static function from(CopyRequest $request): self
    {
        return new self(
            title: $request->input('title'),
        );
    }
}
