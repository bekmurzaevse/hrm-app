<?php

namespace App\Dto\v1\Finance;

use App\Http\Requests\v1\Finance\UpdateIncomeRequest;

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
     * @param \App\Http\Requests\v1\Finance\UpdateIncomeRequest $request
     * @return UpdateIncomeDto
     */
    public static function from(UpdateIncomeRequest $request): self
    {
        return new self(
            categoryIncome: $request->category_income,
            projectId: $request->project_id,
            date: $request->date,
            amount: $request->amount,
            comment: $request->comment,
            description: $request->description,
        );
    }
}
