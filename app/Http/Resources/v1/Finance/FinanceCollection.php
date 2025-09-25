<?php

namespace App\Http\Resources\v1\Finance;

use App\Enums\Finance\CategoryExpenseEnum;
use App\Http\Resources\v1\Finance\Expense\ExpenseResource;
use App\Http\Resources\v1\Finance\Income\IncomeResource;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FinanceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $incomeSum = $this->collection->where('type', 'income')->sum('amount');
        $expenseSum = $this->collection->where('type', 'expense')->sum('amount');
        $profit = $incomeSum - $expenseSum;

        $honorariumSum = $this->collection->where('category_expense', CategoryExpenseEnum::HONORARIUM->value)->sum('amount');
        $honorariumPercent = round($honorariumSum / $expenseSum * 100, 2);

        $adSum = $this->collection->where('category_expense', CategoryExpenseEnum::AD->value)->sum('amount');
        $adPercent = round($adSum / $expenseSum * 100, 2);

        $administrativeSum = $this->collection->where('category_expense', CategoryExpenseEnum::ADMINISTRATIVE->value)->sum('amount');
        $administrativePercent = round($administrativeSum / $expenseSum * 100, 2);

        $dividendSum = $this->collection->where('category_expense', CategoryExpenseEnum::DIVIDEND->value)->sum('amount');
        $dividendPercent = round($dividendSum / $expenseSum * 100, 2);

        $otherSum = $this->collection->where('category_expense', CategoryExpenseEnum::OTHER->value)->sum('amount');
        $otherPercent = round($otherSum / $expenseSum * 100, 2);

        $months = [
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябрь',
            10 => 'Октябрь',
            11 => 'Ноябрь',
            12 => 'Декабрь',
        ];

        $year = now()->year;
        $currentMonth = now()->month;

        $data = Finance::selectRaw('
                MONTH(date) as month,
                SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income,
                SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense,
                SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) -
                SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as net_profit
            ')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', '<=', $currentMonth)
            ->groupBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->month => [
                        'income' => (int) $item->income,
                        'expense' => (int) $item->expense,
                        'net_profit' => (int) $item->net_profit,
                    ]
                ];
            });

        $months = [
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябрь',
            10 => 'Октябрь',
            11 => 'Ноябрь',
            12 => 'Декабрь',
        ];

        $dynamics = [];
        foreach ($months as $num => $name) {
            if ($num > $currentMonth) break;

            $income = $data[$num]['income'] ?? 0;
            $expense = $data[$num]['expense'] ?? 0;

            $dynamics[$name] = [
                'income' => $income,
                'expense' => $expense,
                'net_profit' => $income - $expense,
            ];
        }

        return [
            'card' => [
                'all_income' => $incomeSum,
                'all_expense' => $expenseSum,
                'profit' => $profit,
            ],
            'income' => IncomeResource::collection($this->collection->where('type', 'income')),
            'expense' => ExpenseResource::collection($this->collection->where('type', 'expense')),
            'overview' => [
                'expenses' => [
                    CategoryExpenseEnum::HONORARIUM->value => [
                    'amount' => $honorariumSum,
                    'percent' => $honorariumPercent,
                    ],
                    CategoryExpenseEnum::AD->value => [
                        'amount' => $adSum,
                        'percent' => $adPercent,
                    ],
                    CategoryExpenseEnum::ADMINISTRATIVE->value => [
                        'amount' => $administrativeSum,
                        'percent' => $administrativePercent,
                    ],
                    CategoryExpenseEnum::DIVIDEND->value => [
                        'amount' => $dividendSum,
                        'percent' => $dividendPercent,
                    ],
                    CategoryExpenseEnum::OTHER->value => [
                        'amount' => $otherSum,
                        'percent' => $otherPercent,
                    ],
                ],
                'dynamics' => $dynamics,
            ],
            'items' => IndexResource::collection($this->collection),
            'pagination' => [
                'current_page' => $this->currentPage(),
                'per_page' => $this->perPage(),
                'last_page' => $this->lastPage(),
                'total' => $this->total(),
            ],
        ];
    }
}
