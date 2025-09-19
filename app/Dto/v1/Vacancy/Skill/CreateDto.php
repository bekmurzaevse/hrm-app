<?php

namespace App\Dto\v1\Vacancy\Skill;

use App\Http\Requests\v1\Vacancy\Skill\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public array $titles,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Vacancy\Skill\CreateRequest $request
     * @return CreateDto
     */
    public static function from(CreateRequest $request): self
    {
        return new self(
            titles: $request->input('titles'),
        );
    }
}
