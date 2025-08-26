<?php

namespace App\Dto\v1\Candidate\Contact;

use App\Http\Requests\v1\Candidate\Contact\AddContactRequest;

class AddContactDto
{
    public function __construct(
        public string $title,
        public string $value,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Candidate\Contact\AddContactRequest $request
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
