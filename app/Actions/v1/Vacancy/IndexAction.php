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
            // TODO: add filters, sorting by created_at desc

            return Vacancy::with([
                'client:id,name',
                'createdBy:id,first_name,last_name,patronymic',
                'district:id,title,region_id',
                'district.region:id,title',
            ])->paginate(10);
        });

        return static::toResponse(
            message: 'Successfully Received',
            data: new VacancyCollection($vacancy)
        );
    }
}
