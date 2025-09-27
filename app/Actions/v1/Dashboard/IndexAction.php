<?php

namespace App\Actions\v1\Dashboard;

use App\Dto\v1\Dashboard\IndexDto;
use App\Enums\Vacancy\VacancyStatusEnum;
use App\Http\Resources\v1\Dashboard\ProjectResource;
use App\Models\Candidate;
use App\Models\Client;
use App\Models\Finance;
use App\Models\Project;
use App\Models\ProjectClosure;
use App\Models\User;
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
    public function __invoke(IndexDto $dto)
    {
        $year = now()->year;
        $maxMonth = now()->month;
        $user = auth()->user();
        $role = $user->getRoleNames()->first();

        return Cache::remember("dashboard:$year:$role:$user->id", now()->addMinutes(30), function () use ($year, $maxMonth, $dto, $user) {
            $candidates = Candidate::select(['id', 'created_at', 'user_id'])->cursor();

            $personalCandidates = [];

            foreach ($candidates as $candidate) {
                if ($candidate->created_at->year == $year && $candidate->user_id == $user->id) {
                    $month = $candidate->created_at->format('m'); // '01', '02', ...

                    if (!isset($personalCandidates[$month])) {
                        $personalCandidates[$month] = 0;
                    }

                    $personalCandidates[$month]++;
                }
            }
            $personalCandidates = collect($personalCandidates);

            $vacancies = Vacancy::select(['id', 'created_by', 'status', 'created_at'])->cursor();

            $personalVacancies = [];
            $totalVacanciesClosed = [];
            $vacanciesRaw = [];

            foreach ($vacancies as $vacancy) {
                if (!$vacancy->created_at instanceof Carbon) {
                    $vacancy->created_at = Carbon::parse($vacancy->created_at);
                }

                $month = (int) $vacancy->created_at->format('m');
                $vacancyYear = $vacancy->created_at->year;

                if ($vacancyYear == $year) {
                    if (!isset($vacanciesRaw[$month])) {
                        $vacanciesRaw[$month] = 0;
                    }
                    $vacanciesRaw[$month]++;

                    if ($vacancy->status == VacancyStatusEnum::CLOSED) {
                        if (!isset($totalVacanciesClosed[$month])) {
                            $totalVacanciesClosed[$month] = 0;
                        }
                        $totalVacanciesClosed[$month]++;
                    }

                    if ($vacancy->status == VacancyStatusEnum::CLOSED && $vacancy->created_by == $user->id) {
                        if (!isset($personalVacancies[$month])) {
                            $personalVacancies[$month] = 0;
                        }
                        $personalVacancies[$month]++;
                    }
                }
            }

            $vacanciesRaw = collect($vacanciesRaw);
            $totalVacanciesClosed = collect($totalVacanciesClosed);
            $personalVacancies = collect($personalVacancies);

            $projectsRaw = ProjectClosure::selectRaw('MONTH(closed_at) as month, COUNT(*) as total')
                ->whereYear('closed_at', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $incomesRaw = [];
            $expensesRaw = [];
            $honorarsRaw = [];

            $finances = Finance::select(['id', 'type', 'date', 'category_expense'])->cursor();

            foreach ($finances as $finance) {
                if ($finance->date->year !== $year) {
                    continue;
                }

                $month = $finance->date->format('m'); // '01', '02', ...

                if ($finance->type === 'income') {
                    $incomesRaw[$month] = ($incomesRaw[$month] ?? 0) + $finance->total;
                }

                if ($finance->type === 'expense') {
                    $expensesRaw[$month] = ($expensesRaw[$month] ?? 0) + $finance->total;

                    if ($finance->category_expense === 'honorarium') {
                        $honorarsRaw[$month] = ($honorarsRaw[$month] ?? 0) + $finance->total;
                    }
                }
            }

            $incomesRaw = collect($incomesRaw);
            $expensesRaw = collect($expensesRaw);
            $honorarsRaw = collect($honorarsRaw);

            $candidatesRaw = [];

            foreach ($candidates as $candidate) {
                if ($candidate->created_at->year == $year) {
                    $month = (int) $candidate->created_at->format('m'); // 1–12

                    if (!isset($candidatesRaw[$month])) {
                        $candidatesRaw[$month] = 0;
                    }

                    $candidatesRaw[$month]++;
                }
            }

            $candidatesRaw = collect($candidatesRaw);

            $clientsRaw = Client::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->pluck('total', 'month');

            $users = User::with(['roles'])->role(['manager', 'recruiter'])
                ->withCount([
                    'vacancies as closed_month' => function ($query) {
                        $query->where('status', VacancyStatusEnum::CLOSED)
                            ->whereMonth('updated_at', now()->month)
                            ->whereYear('updated_at', now()->year);
                    },
                    'vacancies as closed_year' => function ($query) {
                        $query->where('status', VacancyStatusEnum::CLOSED)
                            ->whereYear('updated_at', now()->year);
                    },
                    'vacancies as closed_all' => function ($query) {
                        $query->where('status', VacancyStatusEnum::CLOSED);
                    },
                ])
                ->get();

            $projectQuery = Project::with([
                'client',
                'vacancy',
                'inProgressStage',
                'performers',
            ]);

            if ($dto->projectSearch) {
                $projectQuery
                    ->orWhere('comment', 'LIKE', "%{$dto->projectSearch}%")
                    ->orWhereHas('client', function ($q) use ($dto) {
                        $q->where('name', 'LIKE', "%{$dto->projectSearch}%");
                    })
                    ->orWhereHas('performers', function ($q) use ($dto) {
                        $q->where('first_name', 'LIKE', "%{$dto->projectSearch}%");
                        $q->where('last_name', 'LIKE', "%{$dto->projectSearch}%");
                        $q->where('patronymic', 'LIKE', "%{$dto->projectSearch}%");
                    })
                    ->orWhereHas('vacancy', function ($q) use ($dto) {
                        $q->where('title', 'LIKE', "%{$dto->projectSearch}%");
                    });
            }

            if ($dto->projectStatus) {
                $projectQuery->where('status', $dto->projectStatus);
            }

            if ($dto->projectStart && $dto->projectEnd) {
                $start = Carbon::parse($dto->projectStart)->startOfDay(); // 00:00:00
                $end = Carbon::parse($dto->projectEnd)->endOfDay();       // 23:59:59

                $projectQuery->whereBetween('created_at', [$start, $end]);
            } elseif ($dto->projectStart) {
                $start = Carbon::parse($dto->projectStart)->startOfDay();
                $projectQuery->where('created_at', '>=', $start);
            } elseif ($dto->projectEnd) {
                $end = Carbon::parse($dto->projectEnd)->endOfDay();
                $projectQuery->where('created_at', '<=', $end);
            }

            $months = [
                1 => "Январь", 2 => "Февраль", 3 => "Март", 4 => "Апрель",
                5 => "Май", 6 => "Июнь", 7 => "Июль", 8 => "Август",
                9 => "Сентябрь", 10 => "Октябрь", 11 => "Ноябрь", 12 => "Декабрь"
            ];

            $buildList = function ($raw) use ($maxMonth, $months) {
                return collect(range(1, $maxMonth))->map(function ($m) use ($raw, $months) {
                    return [
                        'month' => $months[$m],
                        'count' => $raw->get($m, 0),
                    ];
                })->values();
            };

            $profitRaw = collect(range(1, $maxMonth))->mapWithKeys(function ($m) use ($incomesRaw, $expensesRaw) {
                $income  = $incomesRaw->get($m, 0);
                $expense = $expensesRaw->get($m, 0);
                return [$m => $income - $expense];
            });

            $result = [
                'my_projects' => ProjectResource::collection($projectQuery->get()),
                'personal' => [
                    'vacancies_count' => $vacancies
                        ->where('status', VacancyStatusEnum::CLOSED->value)
                        ->where('created_by', $user->id)
                        ->count(),
                    'vacancies' => $buildList($personalVacancies),
                    'candidates' => $buildList($personalCandidates),
                ],
                'total' => [
                    'candidates_count' => $candidates->count(),
                    'vacancies_open_count' => $vacancies->where('status', VacancyStatusEnum::OPEN->value)->count(),
                    'vacancies_closed_count' => $vacancies->where('status', VacancyStatusEnum::CLOSED->value)->count(),
                    'vacancies_closed' => $buildList($totalVacanciesClosed),
                ],
            ];

            if (auth()->user()->hasAnyRole(['admin', 'manager'])) {
                $result = array_merge($result, [
                            'projects' => Project::with([
                            'client:id,name',
                            'inProgressStage',
                            'vacancy:id,title',
                            'performers:id,first_name,last_name,patronymic',
                            'stages:id,project_id,status',
                        ])
                        ->get()->map( function ($item) {
                        return [
                            'id' => $item->id,
                            'client_name' => $item->client?->name,
                            'vacancy_title' => $item->vacancy?->title,
                            'status' => $item->inProgressStage?->title,
                            'created_at' => $item->created_at->format('Y-m-d'),
                            'deadline' => $item->deadline->format('Y-m-d'),
                            // 'performers' => $item->performers?->map(function ($performer) {
                            //     return $performer?->shortFio;
                            // }),
                            'contract_number' => $item->contract_number,
                            'contract_budget' => $item->contract_budget !== null ? ($item->contract_budget . ' ' . $item->contract_currency) : null,
                            'progress' => $item->progress,
                            'comment' => $item->comment,
                        ];
                    }),
                    'fin_stats' => [
                        'vacancies' => $buildList($vacanciesRaw),
                        'projects' => $buildList($projectsRaw),
                        'income' => $buildList($incomesRaw),
                        'expense' => $buildList($expensesRaw),
                        'expense_honorariums' => $buildList($honorarsRaw),
                        'profit' => $buildList($profitRaw),
                    ],
                    'candidates' => $buildList($candidatesRaw),
                    'clients' => $buildList($clientsRaw),
                    'users' => $users->map(fn($user) => [
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'patronymic' => $user->patronymic,
                        'role' => $user->getRoleNames()->first(),
                        'closed_month' => $user->closed_month,
                        'closed_year' => $user->closed_year,
                        'closed_all' => $user->closed_all,
                    ]),
                ]);
            }

            return $result;
        });
    }
}
