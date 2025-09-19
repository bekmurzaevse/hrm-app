<?php

namespace App\Actions\v1\Project\Stage;

use App\Dto\v1\Project\Stage\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Models\Stage;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Project\Stage\UpdateDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $stageId, UpdateDto $dto): JsonResponse
    {
        try {
            $stage = Stage::findOrFail($stageId);

            $data = [
                'title' => $dto->title,
                'description' => $dto->description,
                'deadline' => $dto->deadline,
                'executor_id' => $dto->executorId,
            ];
            // TODO: add StageDetail, stageOrder

            // Log user activity
            $title = 'Обновление этапа';
            $text = "Этап «{$stage->title}» проекта «{$stage->project->title}» был обновлен.";
            logActivity($title, $text);

            $stage->update($data);

            return static::toResponse(
                message: 'Stage updated'
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException("Stage Not Found", 404);
        }
    }
}
