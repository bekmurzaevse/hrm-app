<?php

namespace App\Http\Requests\v1\Selection\Status\Value;

use App\Http\Requests\v1\Traits\FailedValidation;
use App\Models\Selection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
        $selectionId = $this->route('selectionId');

        return [
            'value' => 'required|string|max:255',
            'selection_item_id' => [
                'required',
                'integer',
                Rule::exists('selection_items', 'id')
                    ->where('selection_id', $selectionId),
            ],
            'selection_status_id' => [
                'required',
                'integer',
                Rule::exists('selection_statuses', 'id')
                    ->where('selection_id', $selectionId),
            ],
        ];
    }
}
