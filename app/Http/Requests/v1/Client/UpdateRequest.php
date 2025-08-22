<?php

namespace App\Http\Requests\v1\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
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
        return [
            'name' => 'required|string|max:50',
            'status' => 'nullable|string|in:Vip,Regular,Problematic',
            'leader' => 'required|string|max:50',
            'contact_person' => 'required|string|max:50',
            'person_position' => 'required|string|max:50',
            'person_phone' => 'required|string',
            'person_email' => 'nullable|string|email',
            'phone' => 'required|string',
            'email' => 'nullable|string',
            'address' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'INN' => 'required|string',
            'employee_count' => 'nullable|string|in:-50,50-250,250+',
            'source' => 'required|string',
            'activity' => 'required|string',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }
}
