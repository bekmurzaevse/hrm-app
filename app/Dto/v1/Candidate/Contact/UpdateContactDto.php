<?php

namespace App\Dto\v1\Candidate\Contact;

use App\Http\Requests\v1\Candidate\Contact\UpdateContactRequest;

readonly class UpdateContactDto
{
    public function __construct(
        public string $title,
        public string $value,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Candidate\Contact\UpdateContactRequest $request
     * @return UpdateContactDto
     */
    public static function from(UpdateContactRequest $request): self
    {
        return new self(
            title: $request->input('title'),
            value: $request->input('value'),
        );
    }
}
