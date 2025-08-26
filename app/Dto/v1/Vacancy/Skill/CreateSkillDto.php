<?php

namespace App\Dto\v1\Vacancy\Skill;

use App\Http\Requests\v1\Vacancy\Skill\CreateSkillRequest;

readonly class CreateSkillDto
{
    public function __construct(
        public array $titles,
    ) {
    }


    public static function from(CreateSkillRequest $request): self
    {
        return new self(
            titles: $request->titles,
        );
    }
}
