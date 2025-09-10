<?php

namespace App\Http\Requests\v1\Task;

use App\Http\Requests\v1\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\Task\TaskPriorityEnum;
use App\Enums\Task\TaskStatusEnum;

class UpdateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::enum(TaskStatusEnum::class)],
            'priority' => ['nullable', Rule::enum(TaskPriorityEnum::class)],
            'deadline' => 'nullable|date_format:m-d-Y',
            'comment' => 'nullable|string|max:1000',
            'created_by' => 'nullable|exists:users,id',
        ];
    }
}