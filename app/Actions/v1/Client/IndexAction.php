<?php

namespace App\Actions\v1\Client;

use App\Dto\v1\Client\IndexDto;
use App\Http\Resources\v1\Client\ClientCollection;
use App\Models\Client;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Client\IndexDto $dto
     * @return JsonResponse
     */
    public function __invoke(IndexDto $dto): JsonResponse
    {
        $key = 'clients:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $clients = Cache::remember($key, now()->addDay(), function () use ($dto) {
            $query = Client::with(['contacts', 'user']);

            if ($dto->status) {
                $query->where('status', $dto->status);
            }

            if ($dto->employeeCount) {
                $query->where('employee_count', $dto->employeeCount);
            }

            if ($dto->userId) {
                $query->where('user_id', $dto->userId);
            }

            if ($dto->search) {
                $query->where('name', 'LIKE', "%{$dto->search}%")
                    ->orWhere('leader', 'LIKE', "%{$dto->search}%")
                    ->orWhere('phone', 'LIKE', "%{$dto->search}%")
                    ->orWhere('email', 'LIKE', "%{$dto->search}%")
                    ->orWhere('address', 'LIKE', "%{$dto->search}%")
                    ->orWhere('INN', 'LIKE', "%{$dto->search}%")
                    ->orWhere('activity', 'LIKE', "%{$dto->search}%")
                    ->orWhere('source', 'LIKE', "%{$dto->search}%");
            }

            $from = $dto->projectFromSum ? (int) $dto->projectFromSum : null;
            $to   = $dto->projectToSum   ? (int) $dto->projectToSum   : null;

            $query->whereHas('projects', function ($q) use ($from, $to) {
                if ($from && $to) {
                    $q->whereBetween('projects.contract_budget', [$from, $to]);
                }
                 elseif ($from) {
                    $q->where('projects.contract_budget', '>=', $from);
                } elseif ($to) {
                    $q->where('projects.contract_budget', '<=', $to);
                }
            });

            $query->withCount('projects');
            if ($dto->fromProject && $dto->toProject) {
                $query->havingBetween('projects_count', [$dto->fromProject, $dto->toProject]);
            } elseif ($dto->fromProject) {
                $query->having('projects_count', '>=', $dto->fromProject);
            } elseif ($dto->toProject) {
                $query->having('projects_count', '<=', $dto->toProject);
            }
            return $query->paginate($dto->perPage ?? 10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new ClientCollection($clients)
        );
    }
}
