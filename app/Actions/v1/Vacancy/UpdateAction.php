<?php

namespace App\Actions\v1\Vacancy;

use App\Dto\Vacancy\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Models\Vacancy;
use App\Models\VacancySalary;
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
                'title' => $dto->title,
                'client_id' => $dto->clientId,
                'department' => $dto->department,
                'city' => $dto->city,
                'type_employment' => $dto->typeEmployment,
                'work_schedule' => $dto->workSchedule,
                'work_experience' => $dto->workExperience,
                'education' => $dto->education,
                'status' => $dto->status,
                'position_count' => $dto->positionCount,
                'created_by' => 1, // TODO: Replace with authenticated user ID
            ]);

            if (!is_null($dto->salary)) {
                $salary = new VacancySalary();
                $salary->salary = $dto->salary;
                $salary->period = $dto->salaryPeriod;

                $vacancy->vacancySalary()->updateOrCreate(
                    ['vacancy_id' => $id],
                    [
                        'salary_from' => $salary->salary_from,
                        'salary_to' => $salary->salary_to,
                        'period' => $salary->period,
                        'currency' => 'USD', // TODO: Implement Salary Currency
                        'bonus' => $dto->bonus,
                        'probation' => $dto->probation,
                        'probation_salary' => $dto->probationSalary,
                    ]
                );
            }

            return static::toResponse(
                message: "id-{$id} Vacancy updated",
                // data: new VacancyResource($vacancy)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Vacancy Not Found', 404);
        }
    }
}
