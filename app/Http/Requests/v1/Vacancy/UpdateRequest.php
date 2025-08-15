<?php

namespace App\Http\Requests\v1\Vacancy;

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
            'title' => 'required|string|min:2|max:255',
            'client_id' => 'required|exists:clients,id',
            'salary' => 'nullable|regex:/^\d+(-\d+)?$/',
            'period' => 'nullable|in:В час,В день,В неделю,В месяц',
            'department' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'type_employment' => 'required|in:В офисе,Удаленно,Временная занятость,Стажировка,Гибридная работа',
            'work_schedule' => 'required|in:Полный день,Гибкий график,Удаленная работа,Сменный график',
            'work_experience' => 'required|in:Без опыта,1-3 года,3-6 лет,Более 6 лет',
            'education' => 'required|in:Среднее,Среднее специальное,Неоконченное высшее,Высшее',
            'bonus' => 'nullable|string|max:1000',
            'probation' => 'nullable|string|max:255',
            'probation_salary' => 'nullable|regex:/^[0-9]+$/',
            'status' => 'required|in:Не активна,Открыта,Закрыта,Не закрыта',
            'position_count' => 'required|integer|min:1',
        ];
    }
}