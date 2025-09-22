<?php

namespace App\Dto\v1\Candidate\Education;

use App\Http\Requests\v1\Candidate\Education\AddEducationRequest;

readonly class AddEducationDto
{
    public function __construct(
        public string $title,
        public string $degree,
        public string $specialty,
        public int $startYear,
        public ?int $endYear,
        public ?string $description,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Candidate\Education\AddEducationRequest $request
     * @return AddEducationDto
     */
    public static function from(AddEducationRequest $request): self
    {
        return new self(
            title: $request->input('title'),
            degree: $request->input('degree'),
            specialty: $request->input('specialty'),
            startYear: $request->input('start_year'),
            endYear: $request->input('end_year'),
            description: $request->input('description'),
        );
    }
}
