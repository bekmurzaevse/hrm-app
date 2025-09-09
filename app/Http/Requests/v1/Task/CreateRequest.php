<?php

namespace App\Http\Requests\v1\Task;

use App\Enums\Task\TaskPriorityEnum;
use App\Enums\Task\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'title' => 'required|string|min:2|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date_format:m-d-Y',
            'status' => ['required', Rule::enum(TaskStatusEnum::class)],
            'priority' => ['required', Rule::enum(TaskPriorityEnum::class)],
            'comment' => 'nullable|string|max:1000',
        ];
    }
}