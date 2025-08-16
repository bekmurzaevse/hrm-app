<?php

namespace App\Dto\Candidate;

use App\Http\Requests\v1\Candidate\AddContactRequest;

 class AddContactDto
{
    public function __construct(
        public string $title,
        public string $value,
    ) {
    }

    public static function from(AddContactRequest $request): self
    {
        return new self(
            title: $request->title,
            value: $request->value,
        );
    }
}
