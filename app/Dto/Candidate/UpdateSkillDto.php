<?php

namespace App\Dto\Candidate;

use App\Http\Requests\v1\Candidate\UpdateSkillRequest;

readonly class UpdateSkillDto
{
    public function __construct(
        public string $title,
    ) {
    }

    public static function from(UpdateSkillRequest $request): self
    {
        return new self(
            title: $request->title,
        );
    }
}
