<?php

namespace App\Http\Resources\v1\Project;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
        $inProgressProjects = $this->where('status', 'В работе')->count();
        $completedProjects = $this->where('status', 'Отменен')->count();
        $totalPrice = $this->sum('contract_budget');

        return [
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
