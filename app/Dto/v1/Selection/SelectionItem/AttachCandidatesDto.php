<?php

namespace App\Dto\v1\Selection\SelectionItem;

use App\Http\Requests\v1\Selection\SelectionItem\AttachCandidatesRequest;

readonly class AttachCandidatesDto
{
    public function __construct(
        public array $selections,
        public array $candidates,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Selection\SelectionItem\AttachCandidatesRequest $request
     * @return AttachCandidatesDto
     */
    public static function from(AttachCandidatesRequest $request): self
    {
        return new self(
            selections: $request->selections,
            candidates: $request->candidates,
        );
    }
}
