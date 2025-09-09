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

        // $year = now()->year;

        // return Cache::remember("dashboard:$year", now()->addMinutes(30), function () use ($year) {
        //     // 🔹 Vacancies oyma-oy
        //     $vacanciesByMonth = Vacancy::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        //         ->whereYear('created_at', $year)
        //         ->groupBy('month')
        //         ->pluck('total', 'month');

        //     // 🔹 Projects oyma-oy
        //     $projectsByMonth = Project::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        //         ->whereYear('created_at', $year)
        //         ->groupBy('month')
        //         ->pluck('total', 'month');

        //     // 🔹 Income oyma-oy
        //     $incomesByMonth = Finance::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        //         ->where('type', 'income')
        //         ->whereYear('created_at', $year)
        //         ->groupBy('month')
        //         ->pluck('total', 'month');

        //     // 🔹 Expense oyma-oy
        //     $expensesByMonth = Finance::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        //         ->where('type', 'expense')
        //         ->whereYear('created_at', $year)
        //         ->groupBy('month')
        //         ->pluck('total', 'month');

        //     // 🔹 1-oydan hozirgi oygacha to‘ldirish
        //     $months = collect(range(1, now()->month))->map(function ($month) use ($vacanciesByMonth, $projectsByMonth, $incomesByMonth, $expensesByMonth) {
        //         $monthName = Carbon::create()->month($month)->format('F');
        //         return [
        //             'month'     => $monthName,
        //             'vacancies' => $vacanciesByMonth->get($month, 0),
        //             'projects'  => $projectsByMonth->get($month, 0),
        //             'income'    => $incomesByMonth->get($month, 0),
        //             'expense'   => $expensesByMonth->get($month, 0),
        //         ];
        //     })->values();

        //     return [
        //         'data' => $months
        //     ];
        // });

        return Cache::remember("dashboard:$year", now()->addMinutes(30), function () use ($year, $maxMonth) {

            // raw pluck: key = month number, value = total
            $vacanciesRaw = \App\Models\Vacancy::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $projectsRaw = \App\Models\Project::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->whereHas('closeProject', function ($q) {
                    $q->whereColumn('project_closures.project_id', 'projects.id');
                })
                ->groupBy('month')
                ->pluck('total', 'month');

            $incomesRaw = \App\Models\Finance::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
                ->where('type', 'income')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $expensesRaw = \App\Models\Finance::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
                ->where('type', 'expense')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            // Helper to build month array (1..current month)
            $buildList = function ($raw) use ($maxMonth) {
                return collect(range(1, $maxMonth))->map(function ($m) use ($raw) {
                    return [
                        'month_number' => $m,
                        'month' => Carbon::create()->month($m)->format('F'), // English month name; o'zgartirish mumkin
                        'total' => $raw->get($m, 0) ? (0 + $raw->get($m)) : 0, // int/float safe cast
                    ];
                })->values();
            };

            return [
                'vacancies' => $buildList($vacanciesRaw),
                'projects'  => $buildList($projectsRaw),
                'income'    => $buildList($incomesRaw),
                'expense'   => $buildList($expensesRaw),
            ];
        });

        // dd("ok");
        // $key = 'projects:dashboard:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        // $datas = Cache::remember($key, now()->addDay(), function () {
        //     return Project::whereHas('closeProject', function ($q) {
        //             $q->whereColumn('project_closures.project_id', 'projects.id');
        //         })
        //         ->selectRaw('MONTHNAME(created_at) as month, COUNT(*) as total')
        //         ->whereYear('created_at', now()->year)
        //         ->groupBy('month')
        //         ->pluck('total', 'month');
        // });

        // // 1 dan 12 gacha bo‘sh joylarni 0 qilib to‘ldirish
        // $contractsByMonth = collect(range(1, now()->month))->mapWithKeys(function ($month) use ($datas) {
        //     $monthName = Carbon::create()->month($month)->format('F'); // January, February...
        //     return [$monthName => $datas->get($month, 0)];
        // });
        // dd($contractsByMonth);

        // return static::toResponse(
        //     message: 'Successfully received',
        //     data: $datas
        //     // data: new TypeCollection($types)
        // );
        // // $contractsByMonth = Project::whereHas('closeProject', function ($q) {
        // //     $q->whereColumn('project_closures.project_id', 'projects.id');
        // // })
        // //     ->selectRaw('MONTHNAME(created_at) as month, COUNT(*) as total')
        // //     ->whereYear('created_at', now()->year)
        // //     ->groupBy('month')
        // //     ->pluck('total', 'month');
        // //     dd($contractsByMonth);
    }
}
