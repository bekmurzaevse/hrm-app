<?php

namespace App\Actions\v1\Project\StageTask;

use App\Exceptions\ApiResponseException;
use App\Models\StageTask;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteStageTaskAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $taskId
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $taskId): JsonResponse
    {
        try {
            $stageTasks = StageTask::findOrFail($taskId);

            // Log user activity
            $title = 'Удаление задачи';
            $text = "Задача «{$stageTasks->title}» была удалена в этапе «{$stageTasks->stage->title}» проекта «{$stageTasks->stage->project->title}»";
            logActivity($title, $text);

            $stageTasks->delete();

            return static::toResponse(
                message: "Stage's task deleted"
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException("Stage's Task Not Found", 404);
        }
    }
}
