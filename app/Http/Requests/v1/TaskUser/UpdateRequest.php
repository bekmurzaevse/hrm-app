<?php

namespace App\Http\Requests\v1\TaskUser;

use App\Enums\Task\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

Class UpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'task_id' => 'sometimes|exists:tasks,id',
            'assigned_at' => 'sometimes|date',
            'status' => ['required', Rule::enum(TaskStatusEnum::class)],
        ];
    }
}