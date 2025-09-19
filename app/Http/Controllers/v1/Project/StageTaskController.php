<?php

namespace App\Http\Controllers\v1\Project;

use App\Actions\v1\Project\Stage\Task\CreateAction;
use App\Actions\v1\Project\Stage\Task\DeleteAction;
use App\Actions\v1\Project\Stage\Task\UpdateAction;
use App\Dto\v1\Project\Stage\Task\CreateDto;
use App\Dto\v1\Project\Stage\Task\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Project\Stage\Task\CreateRequest;
use App\Http\Requests\v1\Project\Stage\Task\UpdateRequest;
use Illuminate\Http\JsonResponse;

class StageTaskController extends Controller
{
    /**
     * Summary of create
     * @param int $stageId
     * @param \App\Http\Requests\v1\Project\Stage\Task\CreateRequest $request
     * @param \App\Actions\v1\Project\Stage\Task\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of update
     * @param int $taskId
     * @param \App\Http\Requests\v1\Project\Stage\Task\UpdateRequest $request
     * @param \App\Actions\v1\Project\Stage\Task\UpdateAction $action
     * @return JsonResponse
     */
    public function update(int $taskId, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($taskId, UpdateDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $taskId
     * @param \App\Actions\v1\Project\Stage\Task\DeleteAction $action
     * @return JsonResponse
     */
    public function delete(int $taskId, DeleteAction $action): JsonResponse
    {
        return $action($taskId);
    }
}
