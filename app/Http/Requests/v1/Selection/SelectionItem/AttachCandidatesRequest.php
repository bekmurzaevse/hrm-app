<?php

namespace App\Http\Requests\v1\Selection\SelectionItem;

use App\Exceptions\ApiResponseException;
use App\Http\Requests\v1\Traits\FailedValidation;
use App\Models\Selection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AttachCandidatesRequest extends FormRequest
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
            'selections' => 'required|array',
            'selections.*' => 'required|integer|exists:selections,id',
            'candidates' => 'required|array',
            'candidates.*' => 'required|integer|exists:candidates,id',
        ];
    }

    /**
     * Summary of withValidator
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $selectionIds = array_unique($this->selections);

            $userSelectionIds = Selection::where('created_by', auth()->id())
                ->whereIn('id', $selectionIds)
                ->pluck('id')
                ->toArray();

            if (!empty(array_diff($selectionIds, $userSelectionIds))) {
                throw new ApiResponseException('Only your own selections are allowed.', 422);
            }
        });
    }
}
