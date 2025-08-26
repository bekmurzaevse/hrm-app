<?php

namespace App\Http\Requests\v1\Candidate\Skill;

use Illuminate\Foundation\Http\FormRequest;

class AddSkillRequest extends FormRequest
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
            'titles' => 'required|array',
            'titles.*' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'titles.required' => "titles ma'jbu'riy.",
            'titles.array' => "titles array boliw kerek.",
        ];
    }
}
