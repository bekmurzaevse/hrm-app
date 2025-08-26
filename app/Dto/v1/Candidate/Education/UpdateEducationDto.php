<?php

namespace App\Dto\v1\Candidate\Education;

use App\Http\Requests\v1\Candidate\Education\UpdateEducationRequest;

class UpdateEducationDto
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

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Candidate\Education\UpdateEducationRequest $request
     * @return UpdateEducationDto
     */
    public static function from(UpdateEducationRequest $request): self
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
