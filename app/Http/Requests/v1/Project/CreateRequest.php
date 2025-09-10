<?php

namespace App\Http\Requests\v1\Project;

use App\Http\Requests\v1\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'title' => 'required|string|min:2|max:255',
            'client_id' => 'required|exists:clients,id',
            'vacancy_id' => 'required|exists:vacancies,id',
            'performers' => 'required|array',
            'performers.*' => 'required|exists:users,id',
            'deadline' => 'required|date_format:m-d-Y',
            'contract_number' => 'nullable|string',
            'contract_budget' => 'nullable|numeric|required_with:contract_number',
            // 'contract_currency' => 'nullable|string|in:USD,|required_with:contract_budget',
            'description' => 'nullable|string',
            'comment' => 'nullable|string',
        ];
    }
}
