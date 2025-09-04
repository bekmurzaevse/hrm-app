<?php

namespace App\Http\Requests\v1\Finance;

use App\Enums\Finance\CategoryIncomeEnum;
use App\Enums\Finance\FinanceTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(FinanceTypeEnum::class)],
            'category_expense' => ['required', Rule::enum(CategoryIncomeEnum::class)],
            'project_id' => 'nullable|integer|exists:projects,id',
            'date' => 'required|date_format:Y-m-d',
            'amount' => 'required|numeric',
            'comment' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}
