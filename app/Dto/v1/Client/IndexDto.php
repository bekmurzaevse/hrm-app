<?php

namespace App\Dto\v1\Client;

use App\Http\Requests\v1\Client\IndexRequest;

readonly class IndexDto
{
    public function __construct(
        public ?string $employeeCount,
        public ?string $status,
        public ?int $userId,
        public ?int $projectFromSum,
        public ?int $projectToSum,
        public ?int $fromProject,
        public ?int $toProject,
        public ?string $search,
        public ?int $perPage,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Client\IndexRequest $request
     * @return IndexDto
     */
    public static function from(IndexRequest $request): self
    {
        return new self(
            employeeCount: $request->input('employee_count'),
            status: $request->input('status'),
            userId: $request->input('user_id'),
            projectFromSum: $request->input('project_from_sum'),
            projectToSum: $request->input('project_to_sum'),
            fromProject: $request->input('from_project'),
            toProject: $request->input('to_project'),
            search: $request->input('search'),
            perPage: $request->input('per_page'),
        );
    }
}
