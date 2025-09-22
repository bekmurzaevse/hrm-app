<?php

namespace App\Http\Requests\v1\Candidate\Experience;

use App\Http\Requests\v1\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class AddWorkExperienceRequest extends FormRequest
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
            'company' => 'required|string|max:50',
            'position' => 'required|string|max:50',
            'start_work' => 'required|string|max:50',
            'end_work' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ];
    }

    /** */
    public function messages(): array
    {
        return [
            'company.required' => "company ma'jbu'riy.",
            'company.string' => "company string boliw kerek.",
            'company.max' => "company 50 belgiden ko'p bolmawi kerek.",
            'position.required' => "position ma'jbu'riy.",
            'position.string' => "position string boliw kerek.",
            'position.max' => "position 50 belgiden ko'p bolmawi kerek.",
            'start_year.required' => "start_year ma'jbu'riy.",
            'start_year.string' => "start_year string boliw kerek.",
            'start_year.max' => "start_year 50 belgiden ko'p bolmawi kerek.",
        ];
    }
}
