<?php

namespace App\Actions\v1\Vacancy;

use App\Dto\v1\Vacancy\UpdateDto;
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
     * @param \App\Dto\v1\Vacancy\UpdateDto $dto
     * @return JsonResponse
     *@throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $id, UpdateDto $dto): JsonResponse
    {
        try {
            $vacancy = Vacancy::findOrFail($id);

            $vacancy->update([
                'title' => $dto->title,
                'client_id' => $dto->clientId,
                'department' => $dto->department,
                'district_id' => $dto->districtId,
                'type_employment' => $dto->typeEmployment,
                'work_schedule' => $dto->workSchedule,
                'work_experience' => $dto->workExperience,
                'education' => $dto->education,
                'status' => $dto->status,
                'position_count' => $dto->positionCount,
                'created_by' => auth()->id(),
                'salary' => $dto->salary,
                'currency' => $dto->currency,
                'period' => $dto->period,
                'bonus' => $dto->bonus,
                'probation' => $dto->probation,
                'probation_salary' => $dto->probationSalary,
                'description' => $dto->description,
                'requirements' => $dto->requirements,
                'responsibilities' => $dto->responsibilities,
                'work_conditions' => $dto->workConditions,
                'benefits' => $dto->benefits,
                // TODO: Add skills if exists in request
            ]);

            // Log user activity
            $title = 'Обновление вакансии';
            $text = "Вакансия «{$vacancy->title}» была обновлена";
            logActivity($title, $text);

            return static::toResponse(
                message: "Vacancy updated",
                // data: new VacancyResource($vacancy)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Vacancy Not Found', 404);
        }
    }
}
