<?php

namespace App\Actions\v1\Type;

use App\Http\Resources\v1\Type\TypeCollection;
use App\Models\Type;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    public function __invoke(): JsonResponse
    {
        $key = 'types:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $types = Cache::remember($key, now()->addDay(), function () {
            return Type::paginate(10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new TypeCollection($types)
        );
    }
}
