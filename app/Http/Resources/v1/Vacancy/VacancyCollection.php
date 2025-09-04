<?php

namespace App\Http\Resources\v1\Vacancy;

use App\Enums\Vacancy\VacancyStatusEnum;
use App\Models\Client;
use App\Models\District;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Cache;

class VacancyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $users = Cache::remember(
        //     'users:filter',
        //     60 * 60 * 24 * 30,
        //     fn() =>
        //     User::role(['admin', 'manager'])->select('id', 'first_name', 'last_name', 'patronymic')->get()
        // );

        return [
            // 'filter' => [
            //     'regions' => Cache::get('regions'),
            //     'districts' => Cache::get('districts'),
            //     'created_by' => $users,
            //     'statuses' => array_column(VacancyStatusEnum::cases(), 'value'),
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
