<?php

namespace App\Actions\v1\Vacancy;

use App\Dto\Vacancy\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\Vacancy\UpdateDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, UpdateDto $dto): JsonResponse
    {
        try {
            $vacancy = Vacancy::findOrFail($id);

            $vacancy->update([
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
            ]);


            return static::toResponse(
                message: "id-{$id} Vacancy updated",
                // data: new VacancyResource($vacancy)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Vacancy Not Found', 404);
        }
    }
}
