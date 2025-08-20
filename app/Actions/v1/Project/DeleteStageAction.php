<?php

namespace App\Actions\v1\Project;

use App\Exceptions\ApiResponseException;
use App\Models\Stage;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteStageAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Project\UpdateStageDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $stageId): JsonResponse
    {
        try {
            $stage = Stage::findOrFail($stageId);

            // TODO: add stageCompetion
            $stage->stageTasks()->delete();
            // TODO: add StageDetail

            // Log user activity
            $title = 'Удаление этапа';
            $text = "Этап «{$stage->title}» проекта «{$stage->project->title}» был удалён.";
            logActivity($title, $text);

            $stage->delete();

            return static::toResponse(
                message: 'Stage deleted'
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException("Stage Not Found", 404);
        }
    }
}
