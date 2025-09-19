<?php

namespace App\Http\Controllers\v1\Project;

use App\Actions\v1\Project\Stage\CompleteAction;
use App\Actions\v1\Project\Stage\CreateAction;
use App\Actions\v1\Project\Stage\DeleteAction;
use App\Actions\v1\Project\Stage\SetRequireAction;
use App\Actions\v1\Project\Stage\UpdateAction;
use App\Dto\v1\Project\Stage\CompleteDto;
use App\Dto\v1\Project\Stage\CreateDto;
use App\Dto\v1\Project\Stage\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Project\Stage\CompleteRequest;
use App\Http\Requests\v1\Project\Stage\CreateRequest;
use App\Http\Requests\v1\Project\Stage\UpdateRequest;
use Illuminate\Http\JsonResponse;

class ProjectStageController extends Controller
{
    /**
     * Summary of create
     * @param int $id
     * @param \App\Http\Requests\v1\Project\Stage\CreateRequest $request
     * @param \App\Actions\v1\Project\Stage\CreateAction $action
     * @return JsonResponse
     */
    public function create(int $id, CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action($id, CreateDto::from($request));
    }

    /**
     * Summary of update
     * @param int $id
     * @param int $stageId
     * @param \App\Http\Requests\v1\Project\Stage\UpdateRequest $request
     * @param \App\Actions\v1\Project\Stage\UpdateAction $action
     * @return JsonResponse
     */
    public function update(int $stageId, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($stageId, UpdateDto::from($request));
    }

    /**
     * Summary of setRequire
     * @param int $id
     * @param int $stageId
     * @param \App\Actions\v1\Project\Stage\SetRequireAction $action
     * @return JsonResponse
     */
    public function setRequire(int $stageId, SetRequireAction $action): JsonResponse
    {
        return $action($stageId);
    }

    /**
     * Summary of complete
     * @param int $stageId
     * @param \App\Http\Requests\v1\Project\Stage\CompleteRequest $request
     * @param \App\Actions\v1\Project\Stage\CompleteAction $action
     * @return JsonResponse
     */
    public function complete(int $stageId, CompleteRequest $request, CompleteAction $action): JsonResponse
    {
        return $action($stageId, CompleteDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $id
     * @param int $stageId
     * @param \App\Actions\v1\Project\Stage\DeleteAction $action
     * @return JsonResponse
     */
    public function delete(int $stageId, DeleteAction $action): JsonResponse
    {
        return $action($stageId);
    }
}
