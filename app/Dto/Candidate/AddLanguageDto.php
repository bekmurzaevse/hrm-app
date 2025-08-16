<?php

namespace App\Dto\Candidate;

use App\Http\Requests\v1\Candidate\AddLanguageRequest;

readonly class AddLanguageDto
{
    public function __construct(
        public string $title,
        public string $degree,
        public ?string $description,
    ) {
    }


    public static function from(AddLanguageRequest $request): self
    {
        return new self(
            title: $request->title,
            degree: $request->degree,
            description: $request->description,
        );
    }
}
