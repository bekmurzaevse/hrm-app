<?php

namespace App\Http\Requests\v1\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class AddWorkExperienceRequest extends FormRequest
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
            'company' => 'required|string|max:50',
            'position' => 'required|string|max:50',
            // 'candidate_id' => 'required|integer|exists:candidates,id',
            'start_work' => 'required|string|max:50',
            'end_work' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ];
    }
}
