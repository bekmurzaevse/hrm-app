<?php

namespace App\Actions\v1\Region;

use App\Dto\v1\Region\IndexDto;
use App\Models\District;
use App\Models\Region;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Region\IndexDto $dto
     * @return JsonResponse
     */
    public function __invoke(IndexDto $dto): JsonResponse
    {
        if ($dto->regionId) {
            $key = 'districts:regionId:' . app()->getLocale() . ':' . md5(request()->fullUrl());
            $regions = Cache::remember($key, now()->addDay(), function () use ($dto){
                $query = District::query();

                if ($dto->regionId) {
                    $query->where('region_id', $dto->regionId);
                }

                return $query->get();
            });
            return static::toResponse(
                    message: 'Successfully received',
                    data: $regions
                );
        } else {
            $key = 'regions:' . app()->getLocale() . ':' . md5(request()->fullUrl());
            $regions = Cache::remember($key, now()->addDay(), function () {
                return Region::all();
            });

            return static::toResponse(
                message: 'Successfully received',
                data: $regions
            );
        }
    }
}
