<?php

namespace App\Dto\v1\Candidate\Experience;

use App\Http\Requests\v1\Candidate\Experience\UpdateWorkExperienceRequest;

readonly class UpdateExperienceDto
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
     * @param \App\Http\Requests\v1\Candidate\Experience\UpdateWorkExperienceRequest $request
     * @return UpdateExperienceDto
     */
    public static function from(UpdateWorkExperienceRequest $request): self
    {
        return new self(
            company: $request->input('company'),
            position: $request->input('position'),
            startWork: $request->input('start_work'),
            endWork: $request->input('end_work'),
            description: $request->input('description'),
        );
    }
}
