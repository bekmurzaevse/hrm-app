<?php

namespace App\Actions\v1\Type;

use App\Models\Type;
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
        $key = 'types:list' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $types = Cache::remember($key, now()->addDay(), function () {
            return Type::select('id', 'title')->get();
        });

        return static::toResponse(
            message: 'Successfully received',
            data: $types
        );
    }
}
