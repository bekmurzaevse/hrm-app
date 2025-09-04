<?php

namespace App\Http\Requests\v1\Candidate;

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
            'gender' => 'nullable|string|in:male,female',
            'status' => 'nullable|string',
            'family_status' => 'nullable|string',
            'from_age' => 'nullable|integer',
            'region_id' => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'to_age' => 'nullable|integer',
            'search' => 'nullable|string',
            'salary_from' => 'nullable|integer',
            'salary_to' => 'nullable|integer',
            'experience_from' => 'nullable|integer',
            'experience_to' => 'nullable|integer',
            'per_page' => 'nullable|integer',
        ];
    }
}
