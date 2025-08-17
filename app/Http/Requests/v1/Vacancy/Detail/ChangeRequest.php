<?php

namespace App\Http\Requests\v1\Vacancy\Detail;

use Illuminate\Foundation\Http\FormRequest;

class ChangeRequest extends FormRequest
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
            'description' => 'required|string|max:1000',
            'requirements' => 'required|string|max:1000',
            'responsibilities' => 'required|string|max:1000',
            'work_conditions' => 'required|string|max:1000',
            'benefits' => 'required|string|max:1000',
        ];
    }
}
