<?php

namespace App\Http\Requests\v1\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerformerRequest extends FormRequest
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
            'performers' => 'required|array',
            'performers.*' => 'required|exists:users,id',
        ];
    }
}
