<?php

namespace App\Actions\v1\Project;

use App\Dto\v1\Project\IndexDto;
use App\Http\Resources\v1\Project\ProjectCollection;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Project\IndexDto $dto
     * @return JsonResponse
     */
    public function __invoke(IndexDto $dto): JsonResponse
    {
        $key = 'projects:' . app()->getLocale() . ':' . md5(request()->fullUrl());

        $projects = Cache::remember($key, now()->addDay(), function () use ($dto) {
            $query = Project::with([
                'client:id,name',
                'inProgressStage',
                'vacancy:id,title',
                'executor:id,first_name,last_name,patronymic',
                'stages:id,project_id,status',
            ]);

            if ($dto->search) {
                $query->where(function ($q) use ($dto) {
                    $q->where('contract_number', 'like', '%' . $dto->search . '%')
                        ->orWhereHas('client', function ($q2) use ($dto) {
                            $q2->where('name', 'like', '%' . $dto->search . '%');
                        })
                        ->orWhereHas('vacancy', function ($q3) use ($dto) {
                            $q3->where('title', 'like', '%' . $dto->search . '%');
                        });
                });
            }

            if ($dto->userId) {
                $query->whereHas('performers', function ($q) use ($dto) {
                    $q->where('user_id', $dto->userId);
                });
            }

            if ($dto->deadlineFrom) {
                $from = Carbon::createFromFormat('d-m-Y', $dto->deadlineFrom)->startOfDay();
                $to = Carbon::createFromFormat('d-m-Y', $dto->deadlineTo)->endOfDay();

                $query->whereBetween('deadline', [$from, $to]);
            }

            if ($dto->contractBudgetFrom) {
                $query->whereBetween('contract_budget', [$dto->contractBudgetFrom, $dto->contractBudgetTo]);
            }

            $query->orderBy('created_at', 'desc');

            return $query->paginate(perPage: $dto->perPage, page: $dto->page);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new ProjectCollection($projects)
        );
    }
}
