<?php

namespace App\Dto\Type;

use App\Http\Requests\v1\Candidate\AddLanguageRequest;
use App\Http\Requests\v1\Type\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public string $title,
        public ?string $description,
    ) {
    }

    public static function from(CreateRequest $request): self
    {
        return new self(
            title: $request->title,
            description: $request->description,
        );
    }
}
