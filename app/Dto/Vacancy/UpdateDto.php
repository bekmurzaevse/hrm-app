<?php

namespace App\Dto\Vacancy;

use App\Http\Requests\v1\Vacancy\UpdateRequest;
use Date;

readonly class UpdateDto
{
    public function __construct(
        public string $title,
        public int $clientId,
        public ?string $salary,
        public ?string $salaryPeriod,
        // TODO: Implement Salary Currency
        public ?string $department,
        public ?string $city,
        public string $typeEmployment,
        public string $workSchedule,
        public string $workExperience,
        public string $education,
        public ?string $bonus,
        public ?string $probation,
        public ?string $probationSalary,
        public string $status,
        public int $positionCount,
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
            salary: $request->salary,
            salaryPeriod: $request->period,
            department: $request->department,
            city: $request->city,
            typeEmployment: $request->type_employment,
            workSchedule: $request->work_schedule,
            workExperience: $request->work_experience,
            education: $request->education,
            bonus: $request->bonus,
            probation: $request->probation,
            probationSalary: $request->probation_salary,
            status: $request->status,
            positionCount: $request->position_count,
        );
    }
}
