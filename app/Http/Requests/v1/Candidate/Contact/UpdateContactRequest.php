<?php

namespace App\Http\Requests\v1\Candidate\Contact;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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
            'value' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => "title ma'jbu'riy.",
            'title.string' => "title string boliw kerek.",
            'title.max' => "title 50 belgiden ko'p bolmawi kerek.",
            'value.required' => "value ma'jbu'riy.",
            'value.string' => "value string boliw kerek.",
            'value.max' => "value 50 belgiden ko'p bolmawi kerek.",
        ];
    }
}
