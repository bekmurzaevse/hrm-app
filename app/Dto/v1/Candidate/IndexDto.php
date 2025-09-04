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
            gender: $request->gender,
            status: $request->status,
            familyStatus: $request->family_status,
            fromAge: $request->from_age,
            regionId: $request->region_id,
            districtId: $request->district_id,
            toAge: $request->to_age,
            search: $request->search,
            salaryFrom: $request->salary_from,
            salaryTo: $request->salary_to,
            experienceFrom: $request->experience_from,
            experienceTo: $request->experience_to,
            perPage: $request->per_page,
        );
    }
}
