<?php

namespace App\Http\Requests\v1\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\Task\TaskPriorityEnum;
use App\Enums\Task\TaskStatusEnum;

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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::enum(TaskStatusEnum::class)],
            'priority' => ['nullable', Rule::enum(TaskPriorityEnum::class)],
            'deadline' => 'nullable|date_format:m-d-Y',
        ];
    }
}