<?php

namespace App\Http\Requests\v1\Project\Stage\Task;

use App\Enums\StageTaskPriorityEnum;
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
            'stage_id' => 'required|integer|exists:stages,id',
            'title' => 'required|string|min:2|max:255',
            'description' => 'nullable|string',
            'executor_id' => 'required|integer|exists:users,id',
            'priority' => ['required', 'string', Rule::enum(StageTaskPriorityEnum::class)],
            'deadline' => 'required|date_format:m-d-Y',
        ];
    }
}
