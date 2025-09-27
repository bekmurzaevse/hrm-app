<?php

namespace App\Dto\v1\Project;

use App\Http\Requests\v1\Project\UpdatePerformersRequest;


readonly class UpdatePerformersDto
{
    public function __construct(
        public array $performers
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\UpdatePerformersRequest $request
     * @return UpdatePerformersDto
     */
    public static function from(UpdatePerformersRequest $request): self
    {
        return new self(
            performers: $request->input('performers')
        );
    }
}
