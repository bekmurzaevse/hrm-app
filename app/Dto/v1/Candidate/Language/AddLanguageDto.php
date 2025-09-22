<?php

namespace App\Dto\v1\Candidate\Language;

use App\Http\Requests\v1\Candidate\Language\AddLanguageRequest;

readonly class AddLanguageDto
{
    public function __construct(
        public string $title,
        public string $degree,
        public ?string $description,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Candidate\Language\AddLanguageRequest $request
     * @return AddLanguageDto
     */
    public static function from(AddLanguageRequest $request): self
    {
        return new self(
            title: $request->input('title'),
            degree: $request->input('degree'),
            description: $request->input('description'),
        );
    }
}
