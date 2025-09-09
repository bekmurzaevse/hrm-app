<?php

namespace App\Actions\v1\Finance\Income;

use App\Dto\v1\Finance\Income\CreateIncomeDto;
use App\Enums\Finance\FinanceTypeEnum;
use App\Models\Finance;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateIncomeAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Finance\Income\CreateIncomeDto $dto
     * @return JsonResponse
     */
    public function __invoke(CreateIncomeDto $dto): JsonResponse
    {
        $data = [
            'type' => FinanceTypeEnum::INCOME,
            'category_income' => $dto->categoryIncome,
            'project_id' => $dto->projectId,
            'date' => $dto->date,
            'amount' => $dto->amount,
            'comment' => $dto->comment,
            'description' => $dto->description,
        ];

        $finance = Finance::create($data);

        logActivity(
            title: 'Создан финансовый доход',
            text: "Доход {$finance->category_income->value} на сумму {$finance->amount} был создан."
        );

        return static::toResponse(
            message: 'Finance Income created'
        );
    }
}
