<?php

namespace App\Dto\v1\Project;

use App\Http\Requests\v1\Project\IndexRequest;

readonly class IndexDto
{
    public function __construct(
        public ?string $search, // client, vacancy, number_contract
        public ?string $deadlineFrom,
        public ?string $deadlineTo,
        public ?int $userId,
        public ?int $contractBudgetFrom,
        public ?int $contractBudgetTo,
        public ?int $perPage,
        public ?int $page,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\IndexRequest $request
     * @return UpdateDto
     */
    public static function from(IndexRequest $request): self
    {
        return new self(
            search: $request->input('search'),
            deadlineFrom: $request->input('deadline_from'),
            deadlineTo: $request->input('deadline_to'),
            userId: $request->input('user_id'),
            contractBudgetFrom: $request->input('contract_budget_from'),
            contractBudgetTo: $request->input('contract_budget_to'),
            perPage: $request->input('per_page', 10),
            page: $request->input('page', 1),
        );
    }
}
