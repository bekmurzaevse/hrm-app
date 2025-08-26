<?php

namespace App\Dto\v1\Vacancy\Skill;

use App\Http\Requests\v1\Vacancy\Skill\UpdateSkillRequest;

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
