<?php

namespace App\Http\Requests\v1\User;

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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'patronymic' => 'required|string|max:50',
            'birth_date' => 'required|string',
            'address' => 'required|string',
            'position' => 'required|string',
            'status' => 'required|in:working,not_working,dismissed',
            'phone' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ];
    }
}
