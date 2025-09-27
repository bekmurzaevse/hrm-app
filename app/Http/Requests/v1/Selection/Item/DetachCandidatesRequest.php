<?php

namespace App\Http\Requests\v1\Selection\Item;

use App\Http\Requests\v1\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class DetachCandidatesRequest extends FormRequest
{
    use FailedValidation;

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
            'items' => 'required|array',
            'items.*' => 'required|integer|exists:selection_items,id',
        ];
    }
}
