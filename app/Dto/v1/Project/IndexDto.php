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
        public ?int $contractBudgetTo
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
            search: $request->search,
            deadlineFrom: $request->deadline_from,
            deadlineTo: $request->deadline_to,
            userId: $request->user_id,
            contractBudgetFrom: $request->contract_budget_from,
            contractBudgetTo: $request->contract_budget_to
        );
    }
}
