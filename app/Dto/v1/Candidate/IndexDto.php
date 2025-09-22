<?php

namespace App\Dto\v1\Candidate;

use App\Http\Requests\v1\Candidate\IndexRequest;

readonly class IndexDto
{
    public function __construct(
        public ?string $gender,
        public ?string $status,
        public ?string $familyStatus,
        public ?int $fromAge,
        public ?int $regionId,
        public ?int $districtId,
        public ?int $toAge,
        public ?string $search,
        public ?float $salaryFrom,
        public ?float $salaryTo,
        public ?float $experienceFrom,
        public ?float $experienceTo,
        public ?int $perPage,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Candidate\IndexRequest $request
     * @return IndexDto
     */
    public static function from(IndexRequest $request): self
    {
        return new self(
            gender: $request->input('gender'),
            status: $request->input('status'),
            familyStatus: $request->input('family_status'),
            fromAge: $request->input('from_age'),
            regionId: $request->input('region_id'),
            districtId: $request->input('district_id'),
            toAge: $request->input('to_age'),
            search: $request->input('search'),
            salaryFrom: $request->input('salary_from'),
            salaryTo: $request->input('salary_to'),
            experienceFrom: $request->input('experience_from'),
            experienceTo: $request->input('experience_to'),
            perPage: $request->input('per_page'),
        );
    }
}
