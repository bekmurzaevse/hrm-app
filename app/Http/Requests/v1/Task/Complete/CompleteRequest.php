<?php

namespace App\Http\Requests\v1\Task\Complete;

use App\Http\Requests\v1\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class CompleteRequest extends FormRequest
{
    use FailedValidation;

    /**
     * Summary of authorize
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Summary of rules
     * @return array{comment: string, task_id: string}
     */
    public function rules(): array
    {
        return [
            'task_id' => 'required|integer|exists:tasks,id',
            'comment' => 'required|string|max:255',
        ];
    }
}
