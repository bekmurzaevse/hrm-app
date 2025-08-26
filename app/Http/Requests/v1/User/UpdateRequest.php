<?php

namespace App\Http\Requests\v1\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'patronymic' => 'required|string|max:50',
            'birth_date' => 'required|string',
            'address' => 'required|string',
            'position' => 'required|string',
            'status' => 'required|in:working,not_working,dismissed',
            'phone' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ];
    }

    /**
     * Summary of messages
     * @return array{address.required: string, address.string: string, email.email: string, email.required: string, email.string: string, first_name.max: string, first_name.required: string, first_name.string: string, last_name.max: string, last_name.required: string, last_name.string: string, password.min: string, password.password: string, password.required: string, patronymic.max: string, patronymic.required: string, patronymic.string: string, phone.required: string, phone.string: string, position.required: string, position.string: string, status.in: string, status.required: string}
     */
    public function messages(): array
    {
        return [
            'first_name.required' => "first_name ma'jbu'riy.",
            'first_name.string' => "first_name string boliw kerek.",
            'first_name.max' => "first_name 50 belgiden ko'p bolmawi kerek.",

            'last_name.required' => "last_name ma'jbu'riy.",
            'last_name.string' => "last_name string boliw kerek.",
            'last_name.max' => "last_name 50 belgiden ko'p bolmawi kerek.",

            'patronymic.required' => "patronymic ma'jbu'riy.",
            'patronymic.string' => "patronymic string boliw kerek.",
            'patronymic.max' => "patronymic 50 belgiden ko'p bolmawi kerek.",

            'address.required' => "address ma'jbu'riy.",
            'address.string' => "address string boliw kerek.",

            'position.required' => "position ma'jbu'riy.",
            'position.string' => "position string boliw kerek.",

            'status.required' => "status ma'jbu'riy.",
            'status.in' => "status ma'nisleri (working, not_working, dismissed) boliwi kerek.",

            'phone.required' => "phone ma'jbu'riy.",
            'phone.string' => "phone string boliw kerek.",

            'email.required' => "email ma'jbu'riy.",
            'email.email' => "email tipinde boliw kerek.",
            'email.string' => "email string boliw kerek.",

            'password.required' => "password ma'jbu'riy.",
            'password.password' => "password tipinde boliw kerek.",
            'password.min' => "password keminde 6 belgi boliwi kerek.",
        ];
    }
}
