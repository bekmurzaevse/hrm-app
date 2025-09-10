<?php

namespace App\Http\Requests\v1\Task\History;

use App\Enums\Task\TaskHistoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
            'type' => ['required', new Enum(TaskHistoryType::class)],
        ];
    }
}
