<?php

namespace App\Http\Controllers\v1\Finance;

use App\Actions\v1\Finance\CreateIncomeAction;
use App\Dto\v1\Finance\CreateIncomeDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Finance\CreateIncomeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function createExpense(CreateIncomeAction $action, CreateIncomeRequest $request): JsonResponse
    {
        return $action(CreateIncomeDto::from($request));
    }


}
