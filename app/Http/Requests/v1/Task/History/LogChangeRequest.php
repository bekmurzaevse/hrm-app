<?php

namespace App\Http\Requests\v1\Task\History;

use App\Enums\Task\TaskHistoryType;
use App\Http\Requests\v1\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class LogChangeRequest extends FormRequest
{
    use FailedValidation;

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
