<?php

namespace App\Actions\v1\Dashboard;

use App\Models\Finance;
use App\Models\Project;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    public function __invoke()
    {

        $year = now()->year;
        $maxMonth = now()->month;

        return Cache::remember("dashboard:$year", now()->addMinutes(30), function () use ($year, $maxMonth) {
            $vacanciesRaw = \App\Models\Vacancy::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $projectsRaw = \App\Models\ProjectClosure::selectRaw('MONTH(closed_at) as month, COUNT(*) as total')
                ->whereYear('closed_at', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $incomesRaw = \App\Models\Finance::selectRaw('MONTH(date) as month, SUM(amount) as total')
                ->where('type', 'income')
                ->whereYear('date', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $expensesRaw = \App\Models\Finance::selectRaw('MONTH(date) as month, SUM(amount) as total')
                ->where('type', 'expense')
                ->whereYear('date', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $honorarsRaw = \App\Models\Finance::selectRaw('MONTH(date) as month, SUM(amount) as total')
                ->where('type', 'expense')
                ->where('category_expense', 'honorarium')
                ->whereYear('date', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $uzMonths = [
                1 => "Январь", 2 => "Февраль", 3 => "Март", 4 => "Апрель",
                5 => "Май", 6 => "Июнь", 7 => "Июль", 8 => "Август",
                9 => "Сентябрь", 10 => "Октябрь", 11 => "Ноябрь", 12 => "Декабрь"
            ];

            $buildList = function ($raw) use ($maxMonth, $uzMonths) {
                return collect(range(1, $maxMonth))->map(function ($m) use ($raw, $uzMonths) {
                    return [
                        'month' => $uzMonths[$m],
                        'count' => $raw->get($m, 0),
                    ];
                })->values();
            };

            $profitRaw = collect(range(1, $maxMonth))->mapWithKeys(function ($m) use ($incomesRaw, $expensesRaw) {
                $income  = $incomesRaw->get($m, 0);
                $expense = $expensesRaw->get($m, 0);
                return [$m => $income - $expense];
            });

            return [
                'vacancies' => $buildList($vacanciesRaw),
                'projects' => $buildList($projectsRaw),
                'income' => $buildList($incomesRaw),
                'expense' => $buildList($expensesRaw),
                'expense_honorariums' => $buildList($honorarsRaw),
                'profit' => $buildList($profitRaw),
            ];
        });

    }
}
