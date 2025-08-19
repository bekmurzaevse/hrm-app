<?php

namespace App\Dto\Project;

use App\Http\Requests\v1\Project\CompleteStageRequest;

readonly class CompleteStageDto
{
    public function __construct(
        public int $candidateCount,
        public ?string $comment,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\CompleteStageRequest $request
     * @return CompleteStageDto
     */
    public static function from(CompleteStageRequest $request): self
    {
        return new self(
            candidateCount: $request->candidate_count,
            comment: $request->comment,
        );
    }
}
