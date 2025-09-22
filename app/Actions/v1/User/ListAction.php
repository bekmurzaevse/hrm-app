<?php

namespace App\Actions\v1\User;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ListAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $key = 'users:list' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $users = Cache::remember($key, now()->addDay(), function () {
            return User::role(['admin','manager'])
                    ->select('id', 'first_name', 'last_name', 'patronymic')
                    ->get();
        });

        return static::toResponse(
            message: 'Successfully received',
            data: $users
        );
    }
}
