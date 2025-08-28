<?php

namespace App\Actions\v1\Client;

use App\Http\Requests\v1\Client\IndexRequest;
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
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request): JsonResponse
    {
        $key = 'clients:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $clients = Cache::remember($key, now()->addDay(), function () use ($request) {
            $query = Client::with(['contacts', 'user']);

            if ($request->status) {
                $query->where('status', $request->status);
            }

            if ($request->employee_count) {
                $query->where('employee_count', $request->employee_count);
            }

            if ($request->user_id) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->search) {
                $query->where('name', 'LIKE', "%{$request->search}%")
                    ->orWhere('leader', 'LIKE', "%{$request->search}%")
                    ->orWhere('phone', 'LIKE', "%{$request->search}%")
                    ->orWhere('email', 'LIKE', "%{$request->search}%")
                    ->orWhere('address', 'LIKE', "%{$request->search}%")
                    ->orWhere('INN', 'LIKE', "%{$request->search}%")
                    ->orWhere('activity', 'LIKE', "%{$request->search}%")
                    ->orWhere('source', 'LIKE', "%{$request->search}%");
            }

            $from = $request->project_from_sum ? (int) $request->project_from_sum : null;
            $to   = $request->project_to_sum   ? (int) $request->project_to_sum   : null;

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
            if ($request->from_project && $request->to_project) {
                $query->havingBetween('projects_count', [$request->from_project, $request->to_project]);
            } elseif ($request->from_project) {
                $query->having('projects_count', '>=', $request->from_project);
            } elseif ($request->to_project) {
                $query->having('projects_count', '<=', $request->to_project);
            }

            return $query->paginate(10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new ClientCollection($clients)
        );
    }
}
