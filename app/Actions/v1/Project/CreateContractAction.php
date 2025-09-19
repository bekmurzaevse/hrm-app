<?php

namespace App\Actions\v1\Project;

use App\Dto\v1\Project\CreateContractDto;
use App\Exceptions\ApiResponseException;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CreateContractAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Project\CreateContractDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, CreateContractDto $dto): JsonResponse
    {
        try {
            $project = Project::findOrFail($id);

            $data = [
                'contract_number' => $dto->contractNumber,
                'contract_budget' => $dto->contractBudget,
                'contract_currency' => 'USD', // TODO: add currency to request, 'contract_currency' => $dto->contractCurrency,
            ];

            $project->update($data);

            // Log user activity
            $title = 'Создал контракт';
            $text = "Контракт для проекта «{$project->title}» был создан.";
            logActivity($title, $text);

            return static::toResponse(
                code: 201,
                message: 'Contract created successfully for project'
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Project not found', 404);
        }
    }
}
