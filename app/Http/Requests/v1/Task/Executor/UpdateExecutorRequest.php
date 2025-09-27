<?php

namespace App\Http\Requests\v1\Task\Executor;

use App\Http\Requests\v1\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExecutorRequest extends FormRequest
{
    use FailedValidation;

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
            'old_user_id' => 'required|exists:users,id',
            'new_user_id' => 'required|exists:users,id|different:old_user_id',
            'comment' => 'nullable|string|max:1000',
        ];
    }
}