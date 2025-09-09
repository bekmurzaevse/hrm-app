<?php

namespace App\Http\Requests\v1\Task\Complete;

use Illuminate\Foundation\Http\FormRequest;

class CompleteRequest extends FormRequest
{

    /**
     * Summary of authorize
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'task_id' => 'required|integer|exists:tasks,id',
            'comment' => 'required|string|max:255',
        ];
    }
}
    