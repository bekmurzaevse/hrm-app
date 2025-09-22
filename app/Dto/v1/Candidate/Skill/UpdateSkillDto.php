<?php

namespace App\Dto\v1\Candidate\Skill;

use App\Http\Requests\v1\Candidate\Skill\UpdateSkillRequest;

readonly class UpdateSkillDto
{
    public function __construct(
        public string $title,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Candidate\Skill\UpdateSkillRequest $request
     * @return UpdateSkillDto
     */
    public static function from(UpdateSkillRequest $request): self
    {
        return new self(
            title: $request->input('title'),
        );
    }
}
