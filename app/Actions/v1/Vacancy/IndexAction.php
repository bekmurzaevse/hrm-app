<?php

namespace App\Actions\v1\Vacancy;

use App\Http\Resources\v1\Vacancy\VacancyCollection;
use App\Models\Vacancy;
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
        $key = 'vacancies:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $vacancy = Cache::remember($key, now()->addDay(), function () {
            return Vacancy::paginate(10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new VacancyCollection($vacancy)
        );
    }
}
