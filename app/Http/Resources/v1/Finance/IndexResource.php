<?php

namespace App\Http\Resources\v1\Finance;

use App\Enums\Finance\CategoryExpenseEnum;
use App\Http\Resources\v1\Finance\Expense\ExpenseResource;
use App\Http\Resources\v1\Finance\Income\IncomeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $incomeSum = $this->where('type', 'income')->sum('amount');
        $expenseSum = $this->where('type', 'expense')->sum('amount');
        $profit = $incomeSum - $expenseSum;

        $honorariumSum = $this->where('category_expense', CategoryExpenseEnum::HONORARIUM->value)->sum('amount');
        $honorariumPercent = round($honorariumSum / $expenseSum * 100, 2);

        $adSum = $this->where('category_expense', CategoryExpenseEnum::AD->value)->sum('amount');
        $adPercent = round($adSum / $expenseSum * 100, 2);

        $administrativeSum = $this->where('category_expense', CategoryExpenseEnum::ADMINISTRATIVE->value)->sum('amount');
        $administrativePercent = round($administrativeSum / $expenseSum * 100, 2);

        $dividendSum = $this->where('category_expense', CategoryExpenseEnum::DIVIDEND->value)->sum('amount');
        $dividendPercent = round($dividendSum / $expenseSum * 100, 2);

        $otherSum = $this->where('category_expense', CategoryExpenseEnum::OTHER->value)->sum('amount');
        $otherPercent = round($otherSum / $expenseSum * 100, 2);

        return [
            'type' => $this->type,
            'category_income' => $this->category_income,
            'category_expense' => $this->category_expense,
            'project_id' => $this->project_id,
            'user_id' => $this->user_id,
            'date' => $this->date,
            'amount' => $this->amount,
            'comment' => $this->comment,
            'description' => $this->description,
            // 'income' => IncomeResource::collection($this->where('type', 'income')->with(['project', 'user'])->get()),
            // 'expense' => ExpenseResource::collection($this->where('type', 'expense')->with(['user', 'project'])->get()),
            // 'overview' => [
            //     'expenses' => [
            //         CategoryExpenseEnum::HONORARIUM->value => [
            //         'amount' => $honorariumSum,
            //         'percent' => $honorariumPercent,
            //         ],
            //         CategoryExpenseEnum::AD->value => [
            //             'amount' => $adSum,
            //             'percent' => $adPercent,
            //         ],
            //         CategoryExpenseEnum::ADMINISTRATIVE->value => [
            //             'amount' => $administrativeSum,
            //             'percent' => $administrativePercent,
            //         ],
            //         CategoryExpenseEnum::DIVIDEND->value => [
            //             'amount' => $dividendSum,
            //             'percent' => $dividendPercent,
            //         ],
            //         CategoryExpenseEnum::OTHER->value => [
            //             'amount' => $otherSum,
            //             'percent' => $otherPercent,
            //         ],
            //     ],
            //     'dynamics' => [

            //     ],
            // ],
        ];
    }
}
