<?php

namespace App\Dto\Candidate;

use App\Http\Requests\v1\Candidate\UpdateContactRequest;

readonly class UpdateContactDto
{
    public function __construct(
        public string $title,
        public string $value,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Candidate\UpdateContactRequest $request
     * @return UpdateContactDto
     */
    public static function from(UpdateContactRequest $request): self
    {
        return new self(
            title: $request->title,
            value: $request->value,
        );
    }
}
