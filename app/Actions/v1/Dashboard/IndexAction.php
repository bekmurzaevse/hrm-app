<?php

namespace App\Actions\v1\Dashboard;

use App\Enums\Vacancy\VacancyStatusEnum;
use App\Models\Candidate;
use App\Models\Client;
use App\Models\Finance;
use App\Models\Project;
use App\Models\ProjectClosure;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     */
    public function __invoke()
    {

        $year = now()->year;
        $maxMonth = now()->month;

        return Cache::remember("dashboard:$year", now()->addMinutes(30), function () use ($year, $maxMonth) {

            //Personal
            $personalCandidates = Candidate::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->where('user_id', auth()->user()->id)
                ->groupBy('month')
                ->pluck('total', 'month');

            $personalVacancies = Vacancy::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->where('created_by', auth()->user()->id)
                ->where('status', VacancyStatusEnum::CLOSED)
                ->groupBy('month')
                ->pluck('total', 'month');

            // Total
            // $totalVacanciesOpen = Vacancy::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            //     ->whereYear('created_at', $year)
            //     ->where('status', VacancyStatusEnum::OPEN)
            //     ->groupBy('month')
            //     ->pluck('total', 'month');

            $totalVacanciesClosed = Vacancy::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->where('status', VacancyStatusEnum::CLOSED)
                ->groupBy('month')
                ->pluck('total', 'month');

            //
            $vacanciesRaw = Vacancy::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $projectsRaw = ProjectClosure::selectRaw('MONTH(closed_at) as month, COUNT(*) as total')
                ->whereYear('closed_at', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $incomesRaw = Finance::selectRaw('MONTH(date) as month, SUM(amount) as total')
                ->where('type', 'income')
                ->whereYear('date', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $expensesRaw = Finance::selectRaw('MONTH(date) as month, SUM(amount) as total')
                ->where('type', 'expense')
                ->whereYear('date', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $honorarsRaw = Finance::selectRaw('MONTH(date) as month, SUM(amount) as total')
                ->where('type', 'expense')
                ->where('category_expense', 'honorarium')
                ->whereYear('date', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $candidatesRaw = Candidate::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $clientsRaw = Client::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
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
                'personal' => [
                    'vacancies_count' => Vacancy::where('status', VacancyStatusEnum::CLOSED->value)
                    ->where('created_by', auth()->user()->id)
                    ->count(),
                    'vacancies' => $buildList($personalVacancies),
                    'candidates' => $buildList($personalCandidates),
                ],
                'total' => [
                    'candidates_count' => Candidate::count(),
                    'vacancies_open_count' => Vacancy::where('status', VacancyStatusEnum::OPEN->value)->count(),
                    'vacancies_closed_count' => Vacancy::where('status', VacancyStatusEnum::CLOSED->value)->count(),
                    'vacancies_closed' => $buildList($totalVacanciesClosed),
                ],
                'vacancies' => $buildList($vacanciesRaw),
                'projects' => $buildList($projectsRaw),
                'income' => $buildList($incomesRaw),
                'expense' => $buildList($expensesRaw),
                'expense_honorariums' => $buildList($honorarsRaw),
                'profit' => $buildList($profitRaw),
                'candidates' => $buildList($candidatesRaw),
                'clients' => $buildList($clientsRaw),
            ];
        });

    }
}
