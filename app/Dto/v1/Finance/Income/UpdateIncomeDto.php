<?php

namespace App\Dto\v1\Finance\Income;

use App\Http\Requests\v1\Finance\Income\UpdateIncomeRequest;

readonly class UpdateIncomeDto
{
    public function __construct(
        public string $categoryIncome,
        public ?int $projectId,
        public string $date,
        public float $amount,
        public ?string $comment,
        public ?string $description,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Finance\Income\UpdateIncomeRequest $request
     * @return UpdateIncomeDto
     */
    public static function from(UpdateIncomeRequest $request): self
    {
        return new self(
            categoryIncome: $request->input('category_income'),
            projectId: $request->input('project_id'),
            date: $request->input('date'),
            amount: $request->input('amount'),
            comment: $request->input('comment'),
            description: $request->input('description'),
        );
    }
}
