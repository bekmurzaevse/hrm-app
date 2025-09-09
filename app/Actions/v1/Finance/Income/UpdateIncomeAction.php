<?php

namespace App\Actions\v1\Finance\Income;

use App\Dto\v1\Finance\Income\UpdateIncomeDto;
use App\Exceptions\ApiResponseException;
use App\Models\Finance;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateIncomeAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\v1\Finance\Income\UpdateIncomeDto $dto
     * @return JsonResponse
     *@throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $id, UpdateIncomeDto $dto): JsonResponse
    {
        try {
            $finance = Finance::findOrFail($id);

            $finance->update([
                'category_income' => $dto->categoryIncome,
                'project_id' => $dto->projectId,
                'date' => $dto->date,
                'amount' => $dto->amount,
                'comment' => $dto->comment,
                'description' => $dto->description,
            ]);

            logActivity(
                title: 'Финансы обновлены',
                text: "Финансовая запись #{$dto->categoryIncome} была обновлена. Сумма: {$finance->amount}, Проект: {$finance->project_id}"
            );

            return static::toResponse(
                message: "$id - id li Finance jan'alandi",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Type Not Found', 404);
        }
    }
}
