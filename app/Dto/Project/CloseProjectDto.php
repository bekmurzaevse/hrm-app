<?php

namespace App\Dto\Project;

use App\Http\Requests\v1\Project\CloseProjectRequest;

readonly class CloseProjectDto
{
    public function __construct(
        public ?string $comment,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\CloseProjectRequest $request
     * @return CloseProjectDto
     */
    public static function from(CloseProjectRequest $request): self
    {
        return new self(
            comment: $request->comment,
        );
    }
}
