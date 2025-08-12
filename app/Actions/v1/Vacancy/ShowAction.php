<?php

namespace App\Actions\v1\Vacancy;

use App\Exceptions\ApiResponseException;
use App\Http\Resources\v1\Vacancy\VacancyResource;
use App\Models\Vacancy;
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
            $key = 'vacancies:show:' . app()->getLocale() . ':' . md5(request()->fullUrl());
            $vacnacy = Cache::remember($key, now()->addDay(), function () use ($id) {
                return Vacancy::findOrFail($id);
            });

            return static::toResponse(
                message: 'Successfully received',
                data: new VacancyResource($vacnacy)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Vacancy Not Found', 404);
        }
    }
}
