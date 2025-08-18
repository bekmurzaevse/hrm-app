<?php

namespace App\Actions\v1\Interaction;

use App\Http\Resources\v1\Interaction\InteractionResource;
use App\Models\Interaction;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    public function __invoke(): JsonResponse
    {
        $key = 'interactions:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $interactions = Cache::remember($key, now()->addDay(), function () {
            return Interaction::paginate(10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: InteractionResource::collection($interactions)
        );
    }
}
