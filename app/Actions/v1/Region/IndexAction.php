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
            $districts = Cache::get('districts', collect());

            $filtered = $districts->where('region_id', $dto->regionId)->values();

            return static::toResponse(
                message: 'Successfully received',
                data: $filtered
            );
        }

        $regions = Cache::get('regions', collect());

        return static::toResponse(
            message: 'Successfully received',
            data: $regions
        );
    }

}
