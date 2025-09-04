<?php

namespace App\Http\Requests\v1\Vacancy;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'search' => 'nullable|string|min:2',
            'position_count' => 'nullable|integer',
            'salary_from' => 'nullable|integer|min:0',
            'salary_to' => 'nullable|integer|min:0',
            'region_id' => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'from' => 'nullable|date_format:Y-m-d|required_with:to',
            'to' => 'nullable|date_format:Y-m-d|required_with:from',
            'status' => 'nullable|string',
            'per_page' => 'nullable|integer',
        ];
    }
}
