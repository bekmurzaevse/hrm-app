<?php

namespace App\Http\Requests\v1\Project;

use App\Http\Requests\v1\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    use FailedValidation;

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
            'search' => 'nullable|string|min:2',
            'deadline_from' => 'nullable|date_format:d-m-Y|required_with:deadline_to',
            'deadline_to' => 'nullable|date_format:d-m-Y|required_with:deadline_from',
            'user_id' => 'nullable|integer',
            'contract_budget_from' => 'nullable|integer|required_with:contract_budget_to',
            'contract_budget_to' => 'nullable|integer|required_with:contract_budget_from',
            'per_page' => 'nullable|integer',
            'page' => 'nullable|integer|min:1',
        ];
    }
}
