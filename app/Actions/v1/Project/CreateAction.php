<?php

namespace App\Actions\v1\Project;

use App\Dto\v1\Project\CreateDto;
use App\Enums\StageStatusEnum;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Project\CreateDto $dto
     * @return JsonResponse
     */
    public function __invoke(CreateDto $dto): JsonResponse
    {
        $data = [
            'title' => $dto->title,
            'client_id' => $dto->clientId,
            'vacancy_id' => $dto->vacancyId,
            'executor_id' => auth()->id(),
            'deadline' => $dto->deadline,
            'contract_number' => $dto->contractNumber,
            'contract_budget' => $dto->contractBudget,
            // 'contract_currency' => $dto->contractCurrency,
            'description' => $dto->description,
            'comment' => $dto->comment,
        ];

        $project = Project::create($data);

        // Default stages
        $defaultStages = [
            'Первичный отбор',
            'Выход на работу',
            'Оплата контракта',
            'Закрытие проекта',
        ];

        $stages = [];
        foreach ($defaultStages as $index => $title) {
            if ($index === 0) {
                $status = StageStatusEnum::IN_PROGRESS;
            } else {
                $status = StageStatusEnum::WAITING;
            }

            $stages[] = [
                'title' => $title,
                'order' => $index + 1,
                'created_by' => auth()->id(),
                'status' => $status,
                'project_id' => $project->id,
                'executor_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $project->stages()->insert($stages);

        // Log user activity
        $title = 'Создал проект';
        $text = "Проект «{$project->title}» был создан.";
        logActivity($title, $text);

        return static::toResponse(
            code: 201,
            message: 'Project created'
        );
    }
}
