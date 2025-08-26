<?php

namespace App\Actions\v1\Client;

use App\Exceptions\ApiResponseException;
use App\Http\Resources\v1\Client\ClientResource;
use App\Models\Client;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ShowAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $key = 'clients:show:' . app()->getLocale() . ':' . md5(request()->fullUrl());
            $client = Cache::remember($key, now()->addDay(), function () use ($id) {
                return Client::with([
                    // 'projects.executor'
                ])->findOrFail($id);
            });

            return static::toResponse(
                message: 'Successfully received',
                data: new ClientResource($client)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Client Not Found', 404);
        }
    }
}
