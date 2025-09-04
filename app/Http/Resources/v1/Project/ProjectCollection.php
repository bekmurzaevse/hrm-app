<?php

namespace App\Http\Resources\v1\Project;

use App\Enums\ProjectStatusEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Cache;

class ProjectCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $totalProjects = $this->count();
        $inProgressProjects = $this->where('status', ProjectStatusEnum::IN_PROGRESS)->count();
        $completedProjects = $this->where('status', ProjectStatusEnum::CANCELLED)->count();
        $totalPrice = $this->sum('contract_budget');

        // $users = Cache::remember(
        //     'users:filter',
        //     60 * 60 * 24 * 30,
        //     fn() =>
        //     User::role(['admin', 'manager'])->select('id', 'first_name', 'last_name', 'patronymic')->get()
        // );

        return [
            // 'filter' => [
            //     'user' => $users
            // ],
            'cards' => [
                'total' => $totalProjects,
                'in_progress' => $inProgressProjects,
                'completed' => $completedProjects,
                'total_price' => $totalPrice,
            ],
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
