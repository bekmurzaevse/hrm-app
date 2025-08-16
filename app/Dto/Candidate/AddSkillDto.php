<?php

namespace App\Dto\Candidate;

use App\Http\Requests\v1\Candidate\AddSkillRequest;

readonly class AddSkillDto
{
    public function __construct(
        public array $titles,
    ) {
    }


    public static function from(AddSkillRequest $request): self
    {
        return new self(
            titles: $request->titles,
        );
    }
}
