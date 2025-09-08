<?php

namespace App\Http\Controllers\v1\Finance;

use App\Actions\v1\Finance\CreateExpenseAction;
use App\Actions\v1\Finance\CreateIncomeAction;
use App\Actions\v1\Finance\DeleteAction;
use App\Actions\v1\Finance\IndexAction;
use App\Actions\v1\Finance\UpdateExpenseAction;
use App\Actions\v1\Finance\UpdateIncomeAction;
use App\Dto\v1\Finance\CreateExpenseDto;
use App\Dto\v1\Finance\CreateIncomeDto;
use App\Dto\v1\Finance\UpdateExpenseDto;
use App\Dto\v1\Finance\UpdateIncomeDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Finance\CreateExpenseRequest;
use App\Http\Requests\v1\Finance\CreateIncomeRequest;
use App\Http\Requests\v1\Finance\UpdateExpenseRequest;
use App\Http\Requests\v1\Finance\UpdateIncomeRequest;
use Illuminate\Http\JsonResponse;

class FinanceController extends Controller
{
    /**
     * Summary of index
     * @param \App\Actions\v1\Finance\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

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

    /**
     * Summary of updateIncome
     * @param int $id
     * @param \App\Actions\v1\Finance\UpdateIncomeAction $action
     * @param \App\Http\Requests\v1\Finance\UpdateIncomeRequest $request
     * @return JsonResponse
     */
    public function updateIncome(int $id, UpdateIncomeAction $action, UpdateIncomeRequest $request): JsonResponse
    {
        return $action($id, UpdateIncomeDto::from($request));
    }

    /**
     * Summary of updateExpense
     * @param int $id
     * @param \App\Actions\v1\Finance\UpdateExpenseAction $action
     * @param \App\Http\Requests\v1\Finance\UpdateExpenseRequest $request
     * @return JsonResponse
     */
    public function updateExpense(int $id, UpdateExpenseAction $action, UpdateExpenseRequest $request): JsonResponse
    {
        return $action($id, UpdateExpenseDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $id
     * @param \App\Actions\v1\Finance\DeleteAction $action
     * @return JsonResponse
     */
    public function delete(int $id, DeleteAction $action): JsonResponse
    {
        return $action($id);
    }

}
