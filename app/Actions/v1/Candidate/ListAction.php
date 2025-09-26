<?php

namespace App\Actions\v1\Candidate;

use App\Enums\User\UserStatusEnum;
use App\Models\Candidate;
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
        $key = 'canidates:list' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $candidates = Cache::remember($key, now()->addDay(), function () {
            return Candidate::whereNot('status', UserStatusEnum::DISMISSED->value)
                    ->select('id', 'first_name', 'last_name', 'patronymic')
                    ->get();
        });

        return static::toResponse(
            message: 'Successfully received',
            data: $candidates
        );
    }
}
