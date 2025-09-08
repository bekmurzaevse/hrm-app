<?php

namespace App\Http\Resources\v1\Finance\Income;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_income' => $this->category_income,
            'project' => $this->project->title ?? null,
            'date' => $this->date->format('Y-m-d'),
            'sum' => $this->amount,
            'comment' => $this->comment,
            'description' => $this->description,
        ];
    }
}
