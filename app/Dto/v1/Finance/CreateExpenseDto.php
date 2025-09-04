<?php

namespace App\Dto\v1\Finance;

use App\Http\Requests\v1\Finance\CreateIncomeRequest;

readonly class CreateExpenseDto
{
    public function __construct(
        public string $type,
        public string $categoryIncome,
        public ?int $projectId,
        public string $date,
        public float $amount,
        public ?string $comment,
        public ?string $description,
    ) {
    }

    
    public static function from(CreateIncomeRequest $request): self
    {
        return new self(
            type: $request->type,
            categoryIncome: $request->category_income,
            projectId: $request->project_id,
            date: $request->date,
            amount: $request->amount,
            comment: $request->comment,
            description: $request->description,
        );
    }
}

