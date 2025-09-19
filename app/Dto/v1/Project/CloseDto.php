<?php

namespace App\Dto\v1\Project;

use App\Http\Requests\v1\Project\CloseRequest;

readonly class CloseDto
{
    public function __construct(
        public ?string $comment,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\CloseRequest $request
     * @return CloseDto
     */
    public static function from(CloseRequest $request): self
    {
        return new self(
            comment: $request->input('comment'),
        );
    }
}
