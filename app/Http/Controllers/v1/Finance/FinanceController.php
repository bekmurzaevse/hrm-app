<?php

namespace App\Http\Controllers\v1\Finance;

use App\Actions\v1\Finance\CreateExpenseAction;
use App\Actions\v1\Finance\CreateIncomeAction;
use App\Dto\v1\Finance\CreateExpenseDto;
use App\Dto\v1\Finance\CreateIncomeDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Finance\CreateExpenseRequest;
use App\Http\Requests\v1\Finance\CreateIncomeRequest;
use Illuminate\Http\JsonResponse;

class FinanceController extends Controller
{

    /**
     * Summary of createIncome
     * @param \App\Actions\v1\Finance\CreateIncomeAction $action
     * @param \App\Http\Requests\v1\Finance\CreateIncomeRequest $request
     * @return JsonResponse
     */
    public function createIncome(CreateIncomeAction $action, CreateIncomeRequest $request): JsonResponse
    {
        return $action(CreateIncomeDto::from($request));
    }

    /**
     * Summary of createExpense
     * @param \App\Actions\v1\Finance\CreateExpenseAction $action
     * @param \App\Http\Requests\v1\Finance\CreateExpenseRequest $request
     * @return JsonResponse
     */
    public function createExpense(CreateExpenseAction $action, CreateExpenseRequest $request): JsonResponse
    {
        return $action(CreateExpenseDto::from($request));
    }

}
