<?php

namespace App\Http\Requests\v1\Task\History;

use Illuminate\Foundation\Http\FormRequest;

class LogChangeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comment' => 'required|string|max:1000',
            'type'    => 'nullable|string|in:executor_added,executor_removed,task_sent,task_completed,note',
        ];
    }
}
