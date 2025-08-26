<?php

namespace App\Actions\v1\Project;

use App\Dto\v1\Project\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Project\UpdateDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, UpdateDto $dto): JsonResponse
    {
        try {
            $project = Project::findOrFail($id);

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

            $project->update($data);

            // Log user activity
            $title = 'Обновил проект';
            $text = "Проект «{$project->title}» был обновлен.";
            logActivity($title, $text);

            if ($dto->performers) {
                $project->performers()->sync($dto->performers);
            }

            return static::toResponse(
                message: "{$id}-Project updated"
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Project Not Found', 404);
        }
    }
}
