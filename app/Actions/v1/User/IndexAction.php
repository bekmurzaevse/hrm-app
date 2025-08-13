<?php

namespace App\Actions\v1\User;

use App\Http\Resources\v1\User\UserCollection;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    public function __invoke(): JsonResponse
    {
        $key = 'users:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $users = Cache::remember($key, now()->addDay(), function () {
            return User::paginate(10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new UserCollection($users)
        );
    }
}
