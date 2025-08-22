<?php

namespace App\Actions\v1\Vacancy;

use App\Dto\Vacancy\CreateDto;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Vacancy\CreateDto $dto
     * @return JsonResponse
     */
    public function __invoke(CreateDto $dto): JsonResponse
    {
        $data = [
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
        ];

        // Log user activity
        $title = 'Создание вакансии';
        $text = "Вакансия «{$dto->title}» была создана.";
        logActivity($title, $text);

        Vacancy::create($data);

        return static::toResponse(
            message: 'Vacancy created'
        );
    }
}