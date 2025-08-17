<?php

namespace App\Actions\v1\Vacancy\Salary;

use App\Dto\Vacancy\Salary\ChangeDto;
use App\Exceptions\ApiResponseException;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ChangeAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Vacancy\Salary\ChangeDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, ChangeDto $dto): JsonResponse
    {
        try {
            $data = [
                'salary' => $dto->salary,
                'period' => $dto->period,
                'bonus' => $dto->bonus,
                'currency' => 'USD', // TODO: Implement Salary Currency
                'probation' => $dto->probation,
                'probation_salary' => $dto->probationSalary,
            ];

            $vacancy = Vacancy::findOrFail($id);

            $vacancy->vacancySalary()->updateOrCreate(
                ['vacancy_id' => $id],
                $data
            );

            return static::toResponse(
                message: "Vacancy's salary changed"
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Vacancy not found', 404);
        }

    }
}
