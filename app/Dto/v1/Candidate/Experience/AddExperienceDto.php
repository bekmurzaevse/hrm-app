<?php

namespace App\Dto\v1\Candidate\Experience;

use App\Http\Requests\v1\Candidate\Experience\AddWorkExperienceRequest;

readonly class AddExperienceDto
{
    public function __construct(
        public string $company,
        public string $position,
        public string $startWork,
        public ?string $endWork,
        public ?string $description,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Candidate\Experience\AddWorkExperienceRequest $request
     * @return AddExperienceDto
     */
    public static function from(AddWorkExperienceRequest $request): self
    {
        return new self(
            company: $request->company,
            position: $request->position,
            startWork: $request->start_work,
            endWork: $request->end_work,
            description: $request->description,
        );
    }
}
