<?php

namespace App\Dto\Vacancy\Salary;

use App\Http\Requests\v1\Vacancy\Salary\ChangeRequest;

readonly class ChangeDto
{
    public function __construct(
        public string $salary,
        public string $period,
        public string $bonus,
        public string $probation,
        public int $probationSalary,
    ) {
    }


    public static function from(ChangeRequest $request): self
    {
        return new self(
            salary: $request->salary,
            period: $request->period,
            bonus: $request->bonus,
            probation: $request->probation,
            probationSalary: $request->probation_salary,
        );
    }
}
