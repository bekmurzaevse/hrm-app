<?php

namespace App\Actions\v1\User;

use App\Http\Requests\v1\User\IndexRequest;
use App\Http\Resources\v1\User\UserCollection;
use App\Models\User;
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
        $key = 'users:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $users = Cache::remember($key, now()->addDay(), function () use ($request) {
            $query = User::with(['projects']);

            if ($request->status) {
                $query->where('status', $request->status);
            }

            if ($request->search) {
                $query->where('first_name', 'LIKE', "%{$request->search}%")
                    ->orWhere('last_name', 'LIKE', "%{$request->search}%")
                    ->orWhere('patronymic', 'LIKE', "%{$request->search}%")
                    ->orWhere('address', 'LIKE', "%{$request->search}%")
                    ->orWhere('position', 'LIKE', "%{$request->search}%")
                    ->orWhere('phone', 'LIKE', "%{$request->search}%")
                    ->orWhere('email', 'LIKE', "%{$request->search}%");
            }

            return $query->paginate(10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new UserCollection($users)
        );
    }
}
