<?php

namespace App\Dto\v1\Vacancy;

use App\Http\Requests\v1\Vacancy\IndexRequest;

readonly class IndexDto
{
    public function __construct(
        public ?string $search,
        public ?int $salaryFrom,
        public ?int $salaryTo,
        public ?int $regionId,
        public ?int $districtId,
        public ?int $userId,
        public ?string $from,
        public ?string $to,
        public ?string $status,
        public ?int $perPage,
        public ?int $page,
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
            search: $request->input("search"),
            salaryFrom: $request->input("salary_from"),
            salaryTo: $request->input("salary_to"),
            regionId: $request->input("region_id"),
            districtId: $request->input("district_id"),
            userId: $request->input("user_id"),
            from: $request->input("from"),
            to: $request->input("to"),
            status: $request->input("status"),
            perPage: $request->input("per_page", 10),
            page: $request->input("page", 1),
        );
    }
}
