<?php

namespace App\Actions\v1\Vacancy;

use App\Dto\Vacancy\CreateDto;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Vacancy\CreateDto $dto
     * @return JsonResponse
     */
    public function __invoke(CreateDto $dto): JsonResponse
    {
        $data = [
            'client_id' => $dto->clientId,
            'title' => $dto->title,
            'description' => $dto->description,
            'city' => $dto->city,
            'type_employment' => $dto->typeEmployment,
            'temporary_from' => $dto->temporaryFrom,
            'temporary_to' => $dto->temporaryTo,
            'salary_min' => $dto->salaryMin,
            'salary_max' => $dto->salaryMax,
            'salary_period' => $dto->salaryPeriod,
            'created_by' => $dto->createdBy,
            'status' => $dto->status,
            'probation_period_value' => $dto->probationPeriodValue,
            'probation_period_unit' => $dto->probationPeriodUnit,
            'probation_salary_amount' => $dto->probationSalaryAmount,
            'probation_salary_period' => $dto->probationSalaryPeriod,
            'experience_min' => $dto->experienceMin,
            'experience_max' => $dto->experienceMax,
            'employee_count' => $dto->employeeCount
        ];

        Vacancy::create($data);


        return static::toResponse(
            message: 'Candidate created'
        );
    }
}
