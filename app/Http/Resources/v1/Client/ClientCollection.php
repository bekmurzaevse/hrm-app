<?php

namespace App\Http\Resources\v1\Client;

use App\Models\Client;
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
        $clients = Client::all();
        $count = 0;
        $activeCount = 0;
        $potentialCount = 0;
        $inactiveCount = 0;

        foreach ($clients as $client){
            $count++;
            if ($client->status === 'Active') {
                $activeCount++;
            }
            if ($client->status === 'Potential') {
                $potentialCount++;
            }
            if ($client->status === 'Inactive') {
                $inactiveCount++;
            }
        }
        return [
            'cards' => [
                'clients_count' => $count,
                'active_count' => $activeCount,
                'potential_count' => $potentialCount,
                'inactive_count' => $inactiveCount,
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
