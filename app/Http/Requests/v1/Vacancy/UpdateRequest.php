<?php

namespace App\Http\Requests\v1\Vacancy;

use App\Enums\Vacancy\CurrencyEnum;
use App\Enums\Vacancy\EducationEnum;
use App\Enums\Vacancy\EmploymentTypeEnum;
use App\Enums\Vacancy\PeriodEnum;
use App\Enums\Vacancy\VacancyStatusEnum;
use App\Enums\Vacancy\WorkExperienceEnum;
use App\Enums\Vacancy\WorkScheduleEnum;
use App\Http\Requests\v1\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'title' => 'required|string|min:2|max:255',
            'client_id' => 'required|exists:clients,id',
            'department' => 'nullable|string|max:255',
            'district_id' => 'required|integer|exists:districts,id',
            'type_employment' => ['required', Rule::enum(EmploymentTypeEnum::class)],
            'work_schedule' => ['required', Rule::enum(WorkScheduleEnum::class)],
            'work_experience' => ['required', Rule::enum(WorkExperienceEnum::class)],
            'education' => ['required', Rule::enum(EducationEnum::class)],
            'status' => ['required', Rule::enum(VacancyStatusEnum::class)],
            'position_count' => 'required|integer|min:1',
            'salary' => 'required|regex:/^\d+(-\d+)?$/',
            'currency' => ['required', Rule::enum(CurrencyEnum::class)],
            'period' => ['required', Rule::enum(PeriodEnum::class)],
            'bonus' => 'nullable|string|max:1000',
            'probation' => 'nullable|string|max:255',
            'probation_salary' => 'nullable|regex:/^[0-9]+$/',
            'description' => 'required|string|max:1000',
            'requirements' => 'required|string|max:1000',
            'responsibilities' => 'required|string|max:1000',
            'work_conditions' => 'required|string|max:1000',
            'benefits' => 'nullable|string|max:1000',
        ];
    }
}
