<?php

namespace App\Actions\v1\Interaction;

use App\Exceptions\ApiResponseException;
use App\Http\Resources\v1\Interaction\InteractionResource;
use App\Models\Interaction;
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
            $key = 'interactions:show:' . app()->getLocale() . ':' . md5(request()->fullUrl());
            $interaction = Cache::remember($key, now()->addDay(), function () use ($id) {
                return Interaction::findOrFail($id);
            });

            return static::toResponse(
                message: 'Successfully received',
                data: new InteractionResource($interaction)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Interaction Not Found', 404);
        }
    }
}
