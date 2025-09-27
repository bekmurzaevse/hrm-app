<?php

namespace App\Dto\v1\Selection\Item;

use App\Http\Requests\v1\Selection\Item\AddExternalCandidatesRequest;

readonly class AddExternalCandidatesDto
{
    public function __construct(
        public array $externalCandidates,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Selection\Item\AddExternalCandidatesRequest $request
     * @return AttachCandidatesDto
     */
    public static function from(AddExternalCandidatesRequest $request): self
    {
        return new self(
            externalCandidates: $request->input('external_candidates'),
        );
    }
}
