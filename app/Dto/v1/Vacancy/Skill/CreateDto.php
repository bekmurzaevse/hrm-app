<?php

namespace App\Dto\v1\Vacancy\Skill;

use App\Http\Requests\v1\Vacancy\Skill\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public array $titles,
    ) {
    }


    public static function from(CreateRequest $request): self
    {
        return new self(
            titles: $request->titles,
        );
    }
}
