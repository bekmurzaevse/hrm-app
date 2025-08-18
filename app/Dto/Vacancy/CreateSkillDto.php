<?php

namespace App\Dto\Vacancy;

use App\Http\Requests\v1\Vacancy\CreateSkillRequest;

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
