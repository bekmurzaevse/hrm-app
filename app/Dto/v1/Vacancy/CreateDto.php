<?php

namespace App\Dto\v1\Vacancy;

use App\Http\Requests\v1\Vacancy\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public string $title,
        public int $clientId,
        public ?string $department,
        public int $districtId,
        public string $typeEmployment,
        public string $workSchedule,
        public string $workExperience,
        public string $education,
        public int $positionCount,
        public string $salary,
        public string $period,
        public string $currency,
        public ?string $bonus,
        public ?string $probation,
        public ?int $probationSalary,
        public string $description,
        public string $requirements,
        public string $responsibilities,
        public string $workConditions,
        public ?string $benefits,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Vacancy\CreateRequest $request
     * @return CreateDto
     */
    public static function from(CreateRequest $request): self
    {
        return new self(
            title: $request->input('title'),
            clientId: $request->input('client_id'),
            department: $request->input('department'),
            districtId: $request->input('district_id'),
            typeEmployment: $request->input('type_employment'),
            workSchedule: $request->input('work_schedule'),
            workExperience: $request->input('work_experience'),
            education: $request->input('education'),
            positionCount: $request->input('position_count'),
            salary: $request->input('salary'),
            period: $request->input('period'),
            currency: $request->input('currency'),
            bonus: $request->input('bonus'),
            probation: $request->input('probation'),
            probationSalary: $request->input('probation_salary'),
            description: $request->input('description'),
            requirements: $request->input('requirements'),
            responsibilities: $request->input('responsibilities'),
            workConditions: $request->input('work_conditions'),
            benefits: $request->input('benefits'),
        );
    }
}
