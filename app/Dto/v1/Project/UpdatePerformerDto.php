<?php

namespace App\Dto\v1\Project;

use App\Http\Requests\v1\Project\UpdatePerformerRequest;

readonly class UpdatePerformerDto
{
    public function __construct(
        public array $performers
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\UpdatePerformerRequest $request
     * @return UpdatePerformerDto
     */
    public static function from(UpdatePerformerRequest $request): self
    {
        return new self(
            performers: $request->performers
        );
    }
}
