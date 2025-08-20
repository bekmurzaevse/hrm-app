<?php

namespace App\Dto\Candidate;

use App\Http\Requests\v1\Candidate\UpdateLanguageRequest;

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
     * @param \App\Http\Requests\v1\Candidate\UpdateLanguageRequest $request
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
