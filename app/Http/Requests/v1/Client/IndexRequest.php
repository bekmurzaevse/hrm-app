<?php

namespace App\Http\Requests\v1\Client;

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
            'employee_count' => 'nullable|string',
            'status' => 'nullable|string',
            'user_id' => 'nullable|integer',
            'project_from_sum' => 'nullable|integer',
            'project_to_sum' => 'nullable|integer',
            'from_project' => 'nullable|integer',
            'to_project' => 'nullable|integer',
            'search' => 'nullable|string',
            'per_page' => 'nullable|integer',
        ];
    }
}
