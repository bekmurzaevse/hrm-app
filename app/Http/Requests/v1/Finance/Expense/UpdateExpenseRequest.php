<?php

namespace App\Http\Requests\v1\Finance\Expense;

use App\Enums\Finance\CategoryExpenseEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExpenseRequest extends FormRequest
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
            'category_expense' => ['required', Rule::enum(CategoryExpenseEnum::class)],
            'project_id' => 'nullable|integer|exists:projects,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'date' => 'required|date_format:Y-m-d',
            'amount' => 'required|numeric',
            'comment' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}
