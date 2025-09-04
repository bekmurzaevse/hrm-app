<?php

namespace App\Actions\v1\Finance;

use App\Dto\v1\Finance\CreateIncomeDto;
use App\Models\Finance;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateIncomeAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Finance\CreateIncomeDto $dto
     * @return JsonResponse
     */
    public function __invoke(CreateIncomeDto $dto): JsonResponse
    {
        $data = [
            'type' => $dto->type,
            'category_income' => $dto->categoryIncome,
            'project_id' => $dto->projectId,
            'date' => $dto->date,
            'amount' => $dto->amount,
            'comment' => $dto->comment,
            'description' => $dto->description,
        ];

        $finance = Finance::create($data);

        logActivity(
            title: 'Finance Income Created',
            text: "Доход #{$finance->id} на сумму {$finance->amount} был создан."
        );

        return static::toResponse(
            message: 'Finance Income created'
        );
    }
}
