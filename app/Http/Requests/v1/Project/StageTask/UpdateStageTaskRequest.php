<?php

namespace App\Http\Requests\v1\Project\StageTask;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStageTaskRequest extends FormRequest
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
            'priority' => 'required|string|in:low,medium,high',
            'deadline' => 'required|date_format:m-d-Y',
        ];
    }
}
