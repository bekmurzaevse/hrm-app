<?php

namespace App\Http\Controllers\v1\Project;

use App\Actions\v1\Project\Stage\CompleteStageAction;
use App\Actions\v1\Project\Stage\CreateStageAction;
use App\Actions\v1\Project\Stage\DeleteStageAction;
use App\Actions\v1\Project\Stage\SetRequireStageAction;
use App\Actions\v1\Project\Stage\UpdateStageAction;
use App\Dto\v1\Project\Stage\CompleteStageDto;
use App\Dto\v1\Project\Stage\CreateStageDto;
use App\Dto\v1\Project\Stage\UpdateStageDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Project\Stage\CompleteStageRequest;
use App\Http\Requests\v1\Project\Stage\CreateStageRequest;
use App\Http\Requests\v1\Project\Stage\UpdateStageRequest;
use Illuminate\Http\JsonResponse;

class ProjectStageController extends Controller
{
    /**
     * Summary of createStage
     * @param int $id
     * @param \App\Http\Requests\v1\Project\Stage\CreateStageRequest $request
     * @param \App\Actions\v1\Project\Stage\CreateStageAction $action
     * @return JsonResponse
     */
    public function createStage(int $id, CreateStageRequest $request, CreateStageAction $action): JsonResponse
    {
        return $action($id, CreateStageDto::from($request));
    }

    /**
     * Summary of updateStage
     * @param int $id
     * @param int $stageId
     * @param \App\Http\Requests\v1\Project\Stage\UpdateStageRequest $request
     * @param \App\Actions\v1\Project\Stage\UpdateStageAction $action
     * @return JsonResponse
     */
    public function updateStage(int $stageId, UpdateStageRequest $request, UpdateStageAction $action): JsonResponse
    {
        return $action($stageId, UpdateStageDto::from($request));
    }

    /**
     * Summary of setRequireStage
     * @param int $id
     * @param int $stageId
     * @param \App\Actions\v1\Project\Stage\SetRequireStageAction $action
     * @return JsonResponse
     */
    public function setRequireStage(int $stageId, SetRequireStageAction $action): JsonResponse
    {
        return $action($stageId);
    }

    /**
     * Summary of completeStage
     * @param int $stageId
     * @param \App\Http\Requests\v1\Project\Stage\CompleteStageRequest $request
     * @param \App\Actions\v1\Project\Stage\CompleteStageAction $action
     * @return JsonResponse
     */
    public function completeStage(int $stageId, CompleteStageRequest $request, CompleteStageAction $action): JsonResponse
    {
        return $action($stageId, CompleteStageDto::from($request));
    }

    /**
     * Summary of deleteStage
     * @param int $id
     * @param int $stageId
     * @param \App\Actions\v1\Project\Stage\DeleteStageAction $action
     * @return JsonResponse
     */
    public function deleteStage(int $stageId, DeleteStageAction $action): JsonResponse
    {
        return $action($stageId);
    }
}
