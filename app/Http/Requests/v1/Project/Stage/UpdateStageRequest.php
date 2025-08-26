<?php

namespace App\Http\Requests\v1\Project\Stage;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStageRequest extends FormRequest
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
            'title' => 'required|string|min:2|max:255',
            'description' => 'nullable|string',
            'executor_id' => 'required|integer|exists:users,id',
            'deadline' => 'required|date_format:m-d-Y',
        ];
    }
}
