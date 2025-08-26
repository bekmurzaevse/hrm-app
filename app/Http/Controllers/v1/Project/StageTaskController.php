<?php

namespace App\Http\Controllers\v1\Project;

use App\Actions\v1\Project\StageTask\CreateStageTaskAction;
use App\Actions\v1\Project\StageTask\DeleteStageTaskAction;
use App\Actions\v1\Project\StageTask\UpdateStageTaskAction;
use App\Dto\v1\Project\StageTask\CreateStageTaskDto;
use App\Dto\v1\Project\StageTask\UpdateStageTaskDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Project\StageTask\CreateStageTaskRequest;
use App\Http\Requests\v1\Project\StageTask\UpdateStageTaskRequest;
use Illuminate\Http\JsonResponse;

class StageTaskController extends Controller
{
    /**
     * Summary of createStageTask
     * @param int $stageId
     * @param \App\Http\Requests\v1\Project\StageTask\CreateStageTaskRequest $request
     * @param \App\Actions\v1\Project\StageTask\CreateStageTaskAction $action
     * @return JsonResponse
     */
    public function createStageTask(CreateStageTaskRequest $request, CreateStageTaskAction $action): JsonResponse
    {
        return $action(CreateStageTaskDto::from($request));
    }

    /**
     * Summary of updateStageTask
     * @param int $taskId
     * @param \App\Http\Requests\v1\Project\StageTask\UpdateStageTaskRequest $request
     * @param \App\Actions\v1\Project\StageTask\UpdateStageTaskAction $action
     * @return JsonResponse
     */
    public function updateStageTask(int $taskId, UpdateStageTaskRequest $request, UpdateStageTaskAction $action): JsonResponse
    {
        return $action($taskId, UpdateStageTaskDto::from($request));
    }

    /**
     * Summary of deleteStageTask
     * @param int $taskId
     * @param \App\Actions\v1\Project\StageTask\DeleteStageTaskAction $action
     * @return JsonResponse
     */
    public function deleteStageTask(int $taskId, DeleteStageTaskAction $action): JsonResponse
    {
        return $action($taskId);
    }
}
