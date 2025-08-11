<?php

namespace App\Http\Requests\v1\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'gender' => 'required|in:male,female',
            'citizenship' => 'required|string',
            'status' => 'required|in:active,in_search,conflictfull,employed',
            'workplace' => 'nullable|string',
            'position' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'salary' => 'required|numeric',
            'desired_salary' => 'required|numeric',
            'source' => 'nullable|string',
            'user_id' => 'required|integer|exists:users,id',
            'experience' => 'nullable|string',
            'description' => 'nullable|string',
            'files' => 'nullable|array|max:5',
            'files.*' => 'required|file|mimes:pdf|max:4096',
        ];
    }
}
