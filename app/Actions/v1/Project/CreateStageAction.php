<?php

namespace App\Actions\v1\Project;

use App\Dto\Project\CreateStageDto;
use App\Exceptions\ApiResponseException;
use App\Models\Project;
use App\Models\Stage;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CreateStageAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Project\CreateStageDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, CreateStageDto $dto): JsonResponse
    {
        try {
            $project = Project::findOrFail($id);
            $afterStage = Stage::findOrFail($dto->stageId);

            Stage::where('order', '>', $afterStage->order)
                ->where('project_id', $project->id)
                ->increment('order');

            $data = [
                'title' => $dto->title,
                'description' => $dto->description,
                'deadline' => $dto->deadline,
                'created_by' => 1, // TODO: Replace with authenticated user ID
                'order' => $afterStage->order + 1,
                'executor_id' => $dto->executorId,
            ];

            $project->stages()->create($data);

            return static::toResponse(
                message: 'Stage created'
            );
        } catch (ModelNotFoundException $e) {
            $model = class_basename($e->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
