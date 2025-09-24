<?php

namespace App\Actions\v1\Project\Stage;

use App\Dto\v1\Project\Stage\CreateDto;
use App\Enums\StageStatusEnum;
use App\Exceptions\ApiResponseException;
use App\Models\Project;
use App\Models\Stage;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Project\Stage\CreateDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, CreateDto $dto): JsonResponse
    {
        try {
            $project = Project::findOrFail($id);
            $afterStage = Stage::findOrFail($dto->stageId);

            if ($afterStage->status === StageStatusEnum::COMPLETED) {
                throw new ApiResponseException(
                    'You cannot create a new stage after ' . $afterStage->title . ' stage',
                    400
                );
            }

            Stage::where('order', '>', $afterStage->order)
                ->where('project_id', $project->id)
                ->increment('order');

            $data = [
                'title' => $dto->title,
                'description' => $dto->description,
                'deadline' => $dto->deadline,
                'created_by' => auth()->id(),
                'order' => $afterStage->order + 1,
                'executor_id' => $dto->executorId,
            ];
            $project->stages()->create($data);

            // Log user activity
            $title = 'Создание этапа';
            $text = "Этап «{$dto->title}» был создан в проекте «{$project->title}».";
            logActivity($title, $text);

            return static::toResponse(
                code: 201,
                message: 'Stage created'
            );
        } catch (ModelNotFoundException $e) {
            $model = class_basename($e->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
