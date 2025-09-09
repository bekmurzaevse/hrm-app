<?php

namespace App\Dto\v1\Finance\Expense;

use App\Http\Requests\v1\Finance\Expense\UpdateExpenseRequest;

readonly class UpdateExpenseDto
{
    public function __construct(
        public string $categoryExpense,
        public ?int $projectId,
        public ?int $userId,
        public string $date,
        public float $amount,
        public ?string $comment,
        public ?string $description,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Finance\Expense\UpdateExpenseRequest $request
     * @return UpdateExpenseDto
     */
    public static function from(UpdateExpenseRequest $request): self
    {
        return new self(
            categoryExpense: $request->category_expense,
            projectId: $request->project_id,
            userId: $request->user_id,
            date: $request->date,
            amount: $request->amount,
            comment: $request->comment,
            description: $request->description,
        );
    }
}

