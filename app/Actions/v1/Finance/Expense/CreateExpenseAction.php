<?php

namespace App\Actions\v1\Finance\Expense;

use App\Dto\v1\Finance\Expense\CreateExpenseDto;
use App\Enums\Finance\FinanceTypeEnum;
use App\Models\Finance;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateExpenseAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Finance\Expense\CreateExpenseDto $dto
     * @return JsonResponse
     */
    public function __invoke(CreateExpenseDto $dto): JsonResponse
    {
        $data = [
            'type' => FinanceTypeEnum::EXPENSE,
            'category_expense' => $dto->categoryExpense,
            'project_id' => $dto->projectId,
            'user_id' => $dto->userId,
            'date' => $dto->date,
            'amount' => $dto->amount,
            'comment' => $dto->comment,
            'description' => $dto->description,
        ];

        $finance = Finance::create($data);

        logActivity(
            title: 'Финансовые расходы созданы',
            text: "Доход {$finance->category_expense->value} на сумму {$finance->amount} был создан."
        );

        return static::toResponse(
            message: 'Finance Expense created'
        );
    }
}
