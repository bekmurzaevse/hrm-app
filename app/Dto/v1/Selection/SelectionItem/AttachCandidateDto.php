<?php

namespace App\Dto\v1\Selection\SelectionItem;

use App\Http\Requests\v1\Selection\SelectionItem\AttachCandidateRequest;

readonly class AttachCandidateDto
{
    public function __construct(
        public array $selections,
        public array $candidates,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Selection\SelectionItem\AttachCandidateRequest $request
     * @return AttachCandidateDto
     */
    public static function from(AttachCandidateRequest $request): self
    {
        return new self(
            selections: $request->selections,
            candidates: $request->candidates,
        );
    }
}
