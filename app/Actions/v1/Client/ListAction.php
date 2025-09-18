<?php

namespace App\Actions\v1\Client;

use App\Models\Client;
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
        $key = 'clients:list' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $clients = Cache::remember($key, now()->addDay(), function () {
            return Client::select('id', 'name')->get();
        });

        return static::toResponse(
            message: 'Successfully received',
            data: $clients
        );
    }
}
