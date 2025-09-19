<?php

namespace App\Dto\v1\Vacancy;

use App\Http\Requests\v1\Vacancy\UpdateRequest;

readonly class UpdateDto
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
        public string $status,
        public int $positionCount,
        public string $salary,
        public string $currency,
        public string $period,
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
     * @param \App\Http\Requests\v1\Vacancy\UpdateRequest $request
     * @return UpdateDto
     */
    public static function from(UpdateRequest $request): self
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
            status: $request->input('status'),
            positionCount: $request->input('position_count'),
            salary: $request->input('salary'),
            currency: $request->input('currency'),
            period: $request->input('period'),
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
