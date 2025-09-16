<?php

namespace App\Http\Requests\v1\Selection\StatusValue;

use App\Http\Requests\v1\Traits\FailedValidation;
use App\Models\Selection;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    use FailedValidation;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $selectionId = (int) $this->route('selectionId');

        return Selection::where('id', $selectionId)
            ->where('created_by', $this->user()->id)
            ->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'value' => 'required|string|max:255',
        ];
    }
}
