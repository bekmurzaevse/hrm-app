<?php

namespace App\Http\Requests\v1\Interaction;

use App\Http\Requests\v1\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'value' => 'required|string',
            'type_id' => 'required|integer|exists:types,id',
            'candidate_id' => 'required|integer|exists:candidates,id',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Summary of messages
     * @return array{candidate_id.exists: string, candidate_id.integer: string, candidate_id.required: string, type_id.exists: string, type_id.integer: string, type_id.required: string, user_id.exists: string, user_id.integer: string, user_id.required: string, value.required: string, value.string: string}
     */
    public function messages(): array
    {
        return [
            'value.required' => "value ma'jbu'riy.",
            'value.string' => "value string boliw kerek.",

            'type_id.required' => "type id kiritiliwi kerek.",
            'type_id.integer' => "type id pu'tin san kiritiliwi kerek.",
            'type_id.exists' => "type id bazada tabilmadi.",

            'candidate_id.required' => "candidate id kiritiliwi kerek.",
            'candidate_id.integer' => "candidate id pu'tin san kiritiliwi kerek.",
            'candidate_id.exists' => "candidate id bazada tabilmadi.",
        ];
    }
}
