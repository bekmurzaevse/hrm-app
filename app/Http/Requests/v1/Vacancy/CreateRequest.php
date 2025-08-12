<?php

namespace App\Http\Requests\v1\Vacancy;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|min:2|max:255',
            'description' => 'nullable|string|min:2|max:1000',
            'city' => 'required|string|min:2|max:255',
            'type_employment' => 'required|in:office,remote,temporary,internship',
            'temporary_from' => 'nullable|date',
            'temporary_to' => 'nullable|date',
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric',
            'salary_period' => 'required|in:month,weak,day,hour',
            'created_by' => 'required|exists:users,id',
            'status' => 'required|in:in_active,open,closed,not_closed',
            'probation_period_value' => 'nullable|integer',
            'probation_period_unit' => 'nullable|in:day,days,month,months',
            'probation_salary_amount' => 'nullable|numeric',
            'probation_salary_period' => 'nullable|in:hour,day,week,month',
            'experience_min' => 'required|integer',
            'experience_max' => 'nullable|integer',
            'employee_count' => 'required|integer',
        ];
    }
}
