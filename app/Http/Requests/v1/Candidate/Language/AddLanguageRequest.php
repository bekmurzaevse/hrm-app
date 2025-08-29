<?php

namespace App\Http\Requests\v1\Candidate\Language;

use Illuminate\Foundation\Http\FormRequest;

class AddLanguageRequest extends FormRequest
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
            'description' => 'nullable|string',
        ];
    }

    /**
     * Summary of messages
     * @return array{degree.max: string, degree.required: string, degree.string: string, title.max: string, title.required: string, title.string: string}
     */
    public function messages()
    {
        return [
            'title.required' => "title ma'jbu'riy.",
            'title.string' => "title string boliw kerek.",
            'title.max' => "title 50 belgiden ko'p bolmawi kerek.",
            'degree.required' => "degree ma'jbu'riy.",
            'degree.string' => "degree string boliw kerek.",
            'degree.max' => "degree 50 belgiden ko'p bolmawi kerek.",
        ];
    }
}
