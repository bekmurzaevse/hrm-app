<?php

namespace App\Actions\v1\Client;

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
    public function __invoke(): JsonResponse
    {
        $key = 'clients:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $clients = Cache::remember($key, now()->addDay(), function () {
            return Client::with('contacts')->paginate(10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new ClientCollection($clients)
        );
    }
}
