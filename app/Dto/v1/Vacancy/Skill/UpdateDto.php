<?php

namespace App\Dto\v1\Vacancy\Skill;

use App\Http\Requests\v1\Vacancy\Skill\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public string $title,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Vacancy\Skill\UpdateRequest $request
     * @return UpdateDto
     */
    public static function from(UpdateRequest $request): self
    {
        return new self(
            title: $request->input('title'),
        );
    }
}
