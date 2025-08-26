<?php

namespace App\Dto\v1\Candidate\Language;

use App\Http\Requests\v1\Candidate\Language\UpdateLanguageRequest;

readonly class UpdateLanguageDto
{
    public function __construct(
        public string $title,
        public string $degree,
        public ?string $description,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Candidate\Language\UpdateLanguageRequest $request
     * @return UpdateLanguageDto
     */
    public static function from(UpdateLanguageRequest $request): self
    {
        return new self(
            title: $request->title,
            degree: $request->degree,
            description: $request->description,
        );
    }
}
