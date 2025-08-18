<?php

namespace App\Http\Requests\v1\Interaction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'value' => 'required|string',
            'type_id' => 'required|integer|exists:types,id',
            'user_id' => 'required|integer|exists:users,id',
            'candidate_id' => 'required|integer|exists:candidates,id',
            'description' => 'nullable|string',
        ];
    }
}
