<?php

namespace App\Dto\v1\Vacancy;

use App\Http\Requests\v1\Vacancy\IndexRequest;

readonly class IndexDto
{
    public function __construct(
        public ?string $search,
        public ?int $positionCount,
        public ?int $salaryFrom,
        public ?int $salaryTo,
        public ?int $regionId,
        public ?int $districtId,
        public ?int $userId,
        public ?string $from,
        public ?string $to,
        public ?string $status,
        public ?int $perPage,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Vacancy\IndexRequest $request
     * @return UpdateDto
     */
    public static function from(IndexRequest $request): self
    {
        return new self(
            search: $request->search,
            positionCount: $request->position_count,
            salaryFrom: $request->salary_from,
            salaryTo: $request->salary_to,
            regionId: $request->region_id,
            districtId: $request->district_id,
            userId: $request->user_id,
            from: $request->from,
            to: $request->to,
            status: $request->status,
            perPage: $request->per_page,
        );
    }
}
