<?php

namespace App\Http\Requests\v1\Client;

use App\Enums\Client\EmlpoyeeCountEnum;
use App\Http\Requests\v1\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use FailedValidation;

    /*
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /*
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'name' => ['required', 'string', 'max:50', Rule::unique('clients', 'name')->ignore($id)],
            'status' => 'nullable|string|in:Active,Potential,Inactive',
            'leader' => 'required|string|max:50',
            'contact_person' => 'required|string|max:50',
            'person_position' => 'required|string|max:50',
            'person_phone' => ['required', 'string', Rule::unique('clients', 'person_phone')->ignore($id)],
            'person_email' => ['nullable', 'string', 'email', Rule::unique('clients', 'person_email')->ignore($id)],
            'phone' => ['required', 'string', Rule::unique('clients', 'phone')->ignore($id)],
            'email' => ['nullable', 'string', 'email', Rule::unique('clients', 'email')->ignore($id)],
            'address' => 'required|string',
            'INN' => ['required', 'string', Rule::unique('clients', 'INN')->ignore($id)],
            'employee_count' => ['nullable', Rule::enum(EmlpoyeeCountEnum::class)],
            'source' => 'required|string',
            'activity' => 'required|string',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Summary of messages
     * @return array{INN.required: string, INN.string: string, activity.required: string, activity.string: string, address.required: string, address.string: string, contact_person.max: string, contact_person.required: string, contact_person.string: string, email.email: string, email.string: string, employee_count.in: string, employee_count.string: string, leader.max: string, leader.required: string, leader.string: string, name.max: string, name.required: string, name.string: string, person_email.email: string, person_email.string: string, person_phone.required: string, person_phone.string: string, person_position.max: string, person_position.required: string, person_position.string: string, phone.required: string, phone.string: string, source.required: string, source.string: string, status.in: string, status.string: string, user_id.exists: string, user_id.required: string, value.max: string, value.required: string, value.string: string}
     */
    public function messages(): array
    {
        return [
            'name.required' => "name ma'jbu'riy.",
            'name.string' => "name string boliw kerek.",
            'name.max' => "name 50 belgiden ko'p bolmawi kerek.",

            'status.string' => "status string boliw kerek.",
            'status.in' => "status ma'nisleri (Active, Potential, Inactive) boliwi kerek.",

            'leader.required' => "leader ma'jbu'riy.",
            'leader.string' => "leader string boliw kerek.",
            'leader.max' => "leader 50 belgiden ko'p bolmawi kerek.",

            'contact_person.required' => "contact_person ma'jbu'riy.",
            'contact_person.string' => "contact_person string boliw kerek.",
            'contact_person.max' => "contact_person 50 belgiden ko'p bolmawi kerek.",

            'person_position.required' => "person_position ma'jbu'riy.",
            'person_position.string' => "person_position string boliw kerek.",
            'person_position.max' => "person_position 50 belgiden ko'p bolmawi kerek.",

            'person_phone.required' => "person_phone ma'jbu'riy.",
            'person_phone.string' => "person_phone string boliw kerek.",

            'person_email.string' => "person_email string boliw kerek.",
            'person_email.email' => "person_email email tipinde boliw kerek.",

            'phone.required' => "phone ma'jbu'riy.",
            'phone.string' => "phone string boliw kerek.",

            'email.email' => "email tipinde boliwi kerek.",
            'email.string' => "email string boliw kerek.",

            'address.required' => "address ma'jbu'riy.",
            'address.string' => "address string boliw kerek.",

            'INN.required' => "INN ma'jbu'riy.",
            'INN.string' => "INN string boliw kerek.",

            'employee_count.string' => "INN string boliw kerek.",
            'employee_count.in' => "status ma'nisleri (-50, 50-250, 250+) boliwi kerek.",

            'source.required' => "source ma'jbu'riy.",
            'source.string' => "source string boliw kerek.",

            'activity.required' => "activity ma'jbu'riy.",
            'activity.string' => "activity string boliw kerek.",

            'value.required' => "value ma'jbu'riy.",
            'value.string' => "value string boliw kerek.",
            'value.max' => "value 50 belgiden ko'p bolmawi kerek.",
        ];
    }
}
