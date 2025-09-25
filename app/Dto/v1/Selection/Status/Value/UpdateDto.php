<?php

namespace App\Dto\v1\Selection\Status\Value;

use App\Http\Requests\v1\Selection\Status\Value\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public string $value,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Selection\Status\Value\UpdateRequest $request
     * @return UpdateDTo
     */
    public static function from(UpdateRequest $request): self
    {
        return new self(
            value: $request->input('value')
        );
    }
}
