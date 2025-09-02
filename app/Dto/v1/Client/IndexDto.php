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
            employeeCount: $request->employee_count,
            status: $request->status,
            userId: $request->user_id,
            projectFromSum: $request->project_from_sum,
            projectToSum: $request->project_to_sum,
            fromProject: $request->from_project,
            toProject: $request->to_project,
            search: $request->search,
        );
    }
}
