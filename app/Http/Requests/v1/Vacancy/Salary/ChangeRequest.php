<?php

namespace App\Http\Requests\v1\Vacancy\Salary;

use Illuminate\Foundation\Http\FormRequest;

class ChangeRequest extends FormRequest
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
            'salary' => 'nullable|regex:/^\d+(-\d+)?$/',
            'period' => 'nullable|in:В час,В день,В неделю,В месяц',
            'bonus' => 'nullable|string|max:1000',
            'probation' => 'nullable|string|max:255',
            'probation_salary' => 'nullable|regex:/^[0-9]+$/',
        ];
    }
}
