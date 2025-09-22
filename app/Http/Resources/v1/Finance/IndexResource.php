<?php

namespace App\Http\Resources\v1\Finance;

use App\Enums\Finance\CategoryExpenseEnum;
use App\Http\Resources\v1\Finance\Expense\ExpenseResource;
use App\Http\Resources\v1\Finance\Income\IncomeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->type,
            'category_income' => $this->category_income,
            'category_expense' => $this->category_expense,
            'project_id' => $this->project_id,
            'user_id' => $this->user_id,
            'date' => $this->date,
            'amount' => $this->amount,
            'comment' => $this->comment,
            'description' => $this->description,
        ];
    }
}
