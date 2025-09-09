<?php

namespace App\Http\Requests\v1\Task\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'comment' => 'nullable|string|max:1000',
        ];
    }
}