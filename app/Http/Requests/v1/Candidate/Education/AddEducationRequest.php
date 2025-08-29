<?php

namespace App\Http\Requests\v1\Candidate\Education;

use Illuminate\Foundation\Http\FormRequest;

class AddEducationRequest extends FormRequest
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
            'title' => 'required|string|max:50',
            'degree' => 'required|string|max:50',
            'specialty' => 'required|string|max:50',
            'start_year' => 'required|string|max:50',
            'end_year' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Summary of messages
     * @return array{degree.max: string, degree.required: string, degree.string: string, end_year.max: string, end_year.required: string, end_year.string: string, specialty.max: string, specialty.required: string, specialty.string: string, start_year.max: string, start_year.required: string, start_year.string: string, title.max: string, title.required: string, title.string: string}
     */
    public function messages(): array
    {
        return [
            'title.required' => "title ma'jbu'riy.",
            'title.string' => "title string boliw kerek.",
            'title.max' => "title 50 belgiden ko'p bolmawi kerek.",

            'degree.required' => "degree ma'jbu'riy.",
            'degree.string' => "degree string boliw kerek.",
            'degree.max' => "degree 50 belgiden ko'p bolmawi kerek.",

            'specialty.required' => "specialty ma'jbu'riy.",
            'specialty.string' => "specialty string boliw kerek.",
            'specialty.max' => "specialty 50 belgiden ko'p bolmawi kerek.",

            'start_year.required' => "start_year ma'jbu'riy.",
            'start_year.string' => "start_year string boliw kerek.",
            'start_year.max' => "start_year 50 belgiden ko'p bolmawi kerek.",

            'end_year.required' => "end_year ma'jbu'riy.",
            'end_year.string' => "end_year string boliw kerek.",
            'end_year.max' => "end_year 50 belgiden ko'p bolmawi kerek.",
        ];
    }
}
