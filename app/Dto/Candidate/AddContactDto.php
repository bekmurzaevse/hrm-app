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

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Candidate\AddContactRequest $request
     * @return AddContactDto
     */
    public static function from(AddContactRequest $request): self
    {
        return new self(
            title: $request->title,
            value: $request->value,
        );
    }
}
