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
            'created_by' => $this->createdBy?->last_name . ' ' . mb_substr($this->createdBy?->first_name, 0, 1, 'UTF-8') . '.' . mb_substr($this->createdBy?->patronymic, 0, 1, 'UTF-8'),
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
            $candidateName = $item->candidate?->last_name . ' ' .
                mb_substr($item->candidate?->first_name, 0, 1, 'UTF-8') . '.' .
                mb_substr($item->candidate?->patronymic, 0, 1, 'UTF-8') . '.';

            $statusValues = $statuses->map(function ($status) use ($item) {
                $statusValue = $item->statusValues->where('status_id', $status['id'])->first();

                return [
                    'status_id' => $status['id'],
                    'value_id' => $statusValue->id ?? null,
                    'value' => $statusValue->value ?? null,
                ];
            });

            return [
                'id' => $item->id,
                'candidate' => $item->candidate_id ? $candidateName : $item->external_name,
                'source' => $item->candidate_id ? 'database' : 'external',
                'status_values' => $statusValues,
            ];
        });

        return array_merge($baseData, [
            'statuses' => $statuses,
            'items' => $items,
        ]);
    }
}