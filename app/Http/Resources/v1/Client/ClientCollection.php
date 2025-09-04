<?php

namespace App\Http\Resources\v1\Client;

use App\Enums\Client\ClientStatusEnum;
use App\Enums\Vacancy\EmploymentTypeEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'filters' => [
            //     'status' => array_column(ClientStatusEnum::cases(), 'value'),
            //     'employee_count' => array_column(EmploymentTypeEnum::cases(), 'value'),
            //     'users' => User::role('manager')
            //         ->select('id', 'first_name', 'last_name', 'patronymic')
            //         ->get(),
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
