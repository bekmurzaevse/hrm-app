<?php

namespace App\Actions\v1\Project;

use App\Dto\v1\Project\CreateDto;
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
            'deadline' => $dto->deadline,
            'contract_number' => $dto->contractNumber,
            'contract_budget' => $dto->contractBudget,
            // 'contract_currency' => $dto->contractCurrency,
            'description' => $dto->description,
            'comment' => $dto->comment,
        ];

        $project = Project::create($data);

        // Log user activity
        $title = 'Создал проект';
        $text = "Проект «{$project->title}» был создан.";
        logActivity($title, $text);

        $project->performers()->attach($dto->performers);

        return static::toResponse(
            code: 201,
            message: 'Project created'
        );
    }
}
