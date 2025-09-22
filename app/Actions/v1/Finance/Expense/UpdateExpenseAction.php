<?php

namespace App\Actions\v1\Finance\Expense;

use App\Dto\v1\Finance\Expense\UpdateExpenseDto;
use App\Enums\Finance\FinanceTypeEnum;
use App\Exceptions\ApiResponseException;
use App\Models\Finance;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateExpenseAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\v1\Finance\Expense\UpdateExpenseDto $dto
     * @return JsonResponse
     *@throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $id, UpdateExpenseDto $dto): JsonResponse
    {
        try {
            $finance = Finance::findOrFail($id);

            $finance->update([
                'type' => FinanceTypeEnum::EXPENSE,
                'category_expense' => $dto->categoryExpense,
                'project_id' => $dto->projectId,
                'user_id' => $dto->userId,
                'date' => $dto->date,
                'amount' => $dto->amount,
                'comment' => $dto->comment,
                'description' => $dto->description,
            ]);

            logActivity(
                title: 'Расход обновлён',
                text: "Финансовая запись #{$finance->categoryExpense} была обновлена как расход. Сумма: {$finance->amount}, Проект: {$finance->project_id}"
            );

            return static::toResponse(
                message: "$id - id li Finance jan'alandi",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Fianace Not Found', 404);
        }
    }
}
