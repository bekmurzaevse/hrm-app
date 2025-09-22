<?php

namespace App\Http\Requests\v1\Candidate\Education;

use App\Enums\Candidate\Education\DegreeEnum;
use App\Http\Requests\v1\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddEducationRequest extends FormRequest
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
            'title' => 'required|string|max:50',
            'degree' => ['required', Rule::enum(DegreeEnum::class)],
            'specialty' => 'required|string|max:50',
            'start_year' => 'required|integer',
            'end_year' => 'nullable|integer',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => "title ma'jbu'riy.",
            'title.string' => "title string boliw kerek.",
            'title.max' => "title 50 belgiden ko'p bolmawi kerek.",

            'degree.required' => "Degree ma'jbu'riy.",
            'degree.in' => "Degree ma'nisleri (male yoki female) boliwi kerek.",

            'specialty.required' => "specialty ma'jbu'riy.",
            'specialty.string' => "specialty string boliw kerek.",
            'specialty.max' => "specialty 50 belgiden ko'p bolmawi kerek.",

            'start_year.required' => "start_year ma'jbu'riy.",
            'start_year.integer' => "start_year pu'tin san boliw kerek.",

            'end_year.required' => "end_year ma'jbu'riy.",
            'end_year.integer' => "end_year pu'tin san boliw kerek.",
        ];
    }
}
