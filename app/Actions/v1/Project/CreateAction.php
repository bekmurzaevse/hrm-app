<?php

namespace App\Actions\v1\Project;

use App\Dto\Project\CreateDto;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Project\CreateDto $dto
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

        $project->performers()->attach($dto->performers);

        return static::toResponse(
            message: 'Project created'
        );
    }
}
