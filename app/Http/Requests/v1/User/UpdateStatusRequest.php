<?php

namespace App\Http\Requests\v1\User;

use App\Enums\User\UserStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStatusRequest extends FormRequest
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
            'status' => ['required', Rule::enum(UserStatusEnum::class)],
        ];
    }

    /**
     * Summary of messages
     * @return array{status.in: string, status.required: string}
     */
    public function messages(): array
    {
        return [
            'status.required' => "status ma'jbu'riy.",
            'status.in' => "status ma'nisleri (working, not_working, dismissed) boliwi kerek.",
        ];
    }
}
