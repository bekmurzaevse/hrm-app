<?php

namespace App\Dto\Candidate;

use App\Http\Requests\v1\Candidate\AddEducationRequest;
use App\Http\Requests\v1\Candidate\AddLanguageRequest;

readonly class AddEducationDto
{
    public function __construct(
        public string $title,
        public string $degree,
        public string $specialty,
        public string $startYear,
        public ?string $endYear,
        public ?string $description,
    ) {
    }

    public static function from(AddEducationRequest $request): self
    {
        return new self(
            title: $request->title,
            degree: $request->degree,
            specialty: $request->specialty,
            startYear: $request->start_year,
            endYear: $request->end_year,
            description: $request->description,
        );
    }
}
