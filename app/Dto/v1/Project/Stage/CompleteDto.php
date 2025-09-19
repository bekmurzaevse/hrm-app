<?php

namespace App\Dto\v1\Project\Stage;

use App\Http\Requests\v1\Project\Stage\CompleteRequest;

readonly class CompleteDto
{
    public function __construct(
        public int $candidateCount,
        public ?string $comment,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\Stage\CompleteRequest $request
     * @return CompleteDto
     */
    public static function from(CompleteRequest $request): self
    {
        return new self(
            candidateCount: $request->input('candidate_count'),
            comment: $request->input('comment'),
        );
    }
}
