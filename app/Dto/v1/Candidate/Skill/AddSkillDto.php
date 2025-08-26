<?php

namespace App\Dto\v1\Candidate\Skill;

use App\Http\Requests\v1\Candidate\Skill\AddSkillRequest;

readonly class AddSkillDto
{
    public function __construct(
        public array $titles,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Candidate\Skill\AddSkillRequest $request
     * @return AddSkillDto
     */
    public static function from(AddSkillRequest $request): self
    {
        return new self(
            titles: $request->titles,
        );
    }
}
