<?php

namespace App\Http\Resources\v1\Finance\Expense;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $haveUser = $this->user->first_name ?? null;
        
        return [
            'id' => $this->id,
            'category_expense' => $this->category_expense,
            'project' => $this->project->title ?? null,
            'user' => $haveUser ? $this->user->first_name . ' ' . $this->user->last_name . ' ' . $this->user->patronymic : $haveUser,
            'date' => $this->date->format('Y-m-d'),
            'sum' => $this->amount,
            'comment' => $this->comment,
            'description' => $this->description,
        ];
    }
}
