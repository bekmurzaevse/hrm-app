<?php

namespace App\Dto\v1\Selection\Item;

use App\Http\Requests\v1\Selection\Item\DetachCandidatesRequest;

readonly class DetachCandidatesDto
{
    public function __construct(
        public array $items,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Selection\Item\DetachCandidatesRequest $request
     * @return DetachCandidatesDto
     */
    public static function from(DetachCandidatesRequest $request): self
    {
        return new self(
            items: $request->input('items'),
        );
    }
}
