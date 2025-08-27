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
            title: $request->title,
            clientId: $request->client_id,
            department: $request->department,
            districtId: $request->district_id,
            typeEmployment: $request->type_employment,
            workSchedule: $request->work_schedule,
            workExperience: $request->work_experience,
            education: $request->education,
            status: $request->status,
            positionCount: $request->position_count,
            salary: $request->salary,
            currency: $request->currency,
            period: $request->period,
            bonus: $request->bonus,
            probation: $request->probation,
            probationSalary: $request->probation_salary,
            description: $request->description,
            requirements: $request->requirements,
            responsibilities: $request->responsibilities,
            workConditions: $request->work_conditions,
            benefits: $request->benefits,
        );
    }
}
