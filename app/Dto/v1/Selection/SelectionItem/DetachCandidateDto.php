<?php

namespace App\Dto\v1\Selection\SelectionItem;

use App\Http\Requests\v1\Selection\SelectionItem\DetachCandidateRequest;

readonly class DetachCandidateDto
{
    public function __construct(
        public array $items,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Selection\SelectionItem\DetachCandidateRequest $request
     * @return DetachCandidateDto
     */
    public static function from(DetachCandidateRequest $request): self
    {
        return new self(
            items: $request->items,
        );
    }
}
