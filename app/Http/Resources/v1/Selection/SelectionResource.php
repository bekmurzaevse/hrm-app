<?php

namespace App\Http\Resources\v1\Selection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SelectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $baseData = [
            'id' => $this->id,
            'title' => $this->title,
            'created_at' => $this->created_at?->format('Y-m-d'),
            'created_by' => $this->createdBy?->shortFio,
            'candidates' => $this->items->count(),
            'candidates_count' => $this->items->whereNotNull('candidate_id')->count(),
            'external_count' => $this->items->whereNotNull('external_name')->count(),
        ];

        $statuses = collect([
            [
                'id' => null,
                'title' => 'Соискатель',
                'order' => 0,
            ],
        ])->merge(
                $this->statuses->map(function ($status) {
                    return [
                        'id' => $status->id,
                        'title' => $status->title,
                        'order' => $status->order,
                    ];
                })
            )->sortBy('order')->values();

        $items = $this->items->map(function ($item) use ($statuses) {

            $statusValues = $statuses->map(function ($status) use ($item) {

                // For first status
                if ($status['id'] === null) {
                    $candidateName = $item->candidate?->shortFio;

                    return [
                        'status_id' => null,
                        'value_id' => $item->id,
                        'value' => $item->candidate_id ? $candidateName : $item->external_name,
                        'source' => $item->candidate_id ? 'database' : 'external',
                    ];
                }

                // Other statuses
                $statusValue = $item->statusValues->where('selection_status_id', $status['id'])->first();

                return [
                    'status_id' => $status['id'],
                    'value_id' => $statusValue->id ?? null,
                    'value' => $statusValue->value ?? null,
                ];
            });

            return [
                'item_id' => $item->id,
                'status_values' => $statusValues
            ];
        });

        return array_merge($baseData, [
            'statuses' => $statuses->toArray(),
            'items' => $items->toArray(),
        ]);
    }
}