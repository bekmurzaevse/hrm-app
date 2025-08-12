<?php

namespace App\Dto\Vacancy;

use App\Http\Requests\v1\Vacancy\CreateRequest;
use Date;

readonly class CreateDto
{
    public function __construct(
        public int $clientId,
        public string $title,
        public ?string $description,
        public string $city,
        public string $typeEmployment,
        public ?Date $temporaryFrom,
        public ?Date $temporaryTo,
        public float $salaryMin,
        public float $salaryMax,
        public string $salaryPeriod,
        public int $createdBy,
        public string $status,
        public ?int $probationPeriodValue,
        public ?string $probationPeriodUnit,
        public ?float $probationSalaryAmount,
        public ?string $probationSalaryPeriod,
        public int $experienceMin,
        public ?int $experienceMax,
        public int $employeeCount,
    ) {
    }


    public static function from(CreateRequest $request): self
    {
        return new self(
            clientId: $request->client_id,
            title: $request->title,
            description: $request->description,
            city: $request->city,
            typeEmployment: $request->type_employment,
            temporaryFrom: $request->temporary_from,
            temporaryTo: $request->temporary_to,
            salaryMin: $request->salary_min,
            salaryMax: $request->salary_max,
            salaryPeriod: $request->salary_period,
            createdBy: $request->created_by,
            status: $request->status,
            probationPeriodValue: $request->probation_period_value,
            probationPeriodUnit: $request->probation_period_unit,
            probationSalaryAmount: $request->probation_salary_amount,
            probationSalaryPeriod: $request->probation_salary_period,
            experienceMin: $request->experience_min,
            experienceMax: $request->experience_max,
            employeeCount: $request->employee_count
        );
    }
}
