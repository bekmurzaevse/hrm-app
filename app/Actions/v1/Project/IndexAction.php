<?php

namespace App\Actions\v1\Project;

use App\Dto\v1\Project\IndexDto;
use App\Http\Resources\v1\Project\ProjectCollection;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(IndexDto $dto): JsonResponse
    {
        $key = 'projects:' . app()->getLocale() . ':' . md5(request()->fullUrl());

        $projects = Cache::remember($key, now()->addDay(), function () use ($dto) {
            $query = Project::with([
                'client:id,name',
                'inProgressStage',
                'vacancy:id,title',
                'performers:id,first_name,last_name,patronymic',
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
                $query->whereBetween('deadline', [$dto->deadlineFrom, $dto->deadlineTo]);
            }

            if ($dto->contractBudgetFrom) {
                $query->whereBetween('contract_budget', [$dto->contractBudgetFrom, $dto->contractBudgetTo]);
            }

            return $query->paginate($dto->perPage ?? 10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new ProjectCollection($projects)
        );
    }
}
