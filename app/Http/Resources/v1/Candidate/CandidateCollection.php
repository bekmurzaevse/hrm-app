<?php

namespace App\Http\Resources\v1\Candidate;

use App\Enums\GenderEnum;
use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Cache;

class CandidateCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $regions = Cache::get('regions');
        // $districts = Cache::get('districts');

        return [
            // 'filters' => [
            //     'gender' => array_column(GenderEnum::cases(), 'value'),
            //     'regions' => $regions->map(function ($region) {
            //         return [
            //             'id' => $region->id,
            //             'title' => $region->title,
            //         ];
            //     }),
            //     'districts' => $districts->map(function ($district) {
            //         return [
            //             'id' => $district->id,
            //             'region_id' => $district->region_id,
            //             'title' => $district->title,
            //         ];
            //     }),
            // ],
            'items' => IndexResource::collection($this->collection),
            'pagination' => [
                'current_page' => $this->currentPage(),
                'per_page' => $this->perPage(),
                'last_page' => $this->lastPage(),
                'total' => $this->total(),
            ],
        ];
    }
}
