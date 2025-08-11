<?php

namespace App\Actions\v1\Candidate;

use App\Http\Resources\v1\Candidate\CandidateCollection;
use App\Models\Candidate;
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
        $key = 'candidates:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $candidates = Cache::remember($key, now()->addDay(), function () {
            return Candidate::paginate(10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new CandidateCollection($candidates)
        );
    }
}
