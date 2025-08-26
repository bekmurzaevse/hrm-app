<?php

namespace App\Http\Controllers\v1\Project;

use App\Actions\v1\Project\CloseProjectAction;
use App\Actions\v1\Project\CreateAction;
use App\Actions\v1\Project\CreateContractAction;
use App\Actions\v1\Project\IndexAction;
use App\Actions\v1\Project\ShowAction;
use App\Actions\v1\Project\UpdateAction;
use App\Actions\v1\Project\UpdatePerformerAction;
use App\Dto\v1\Project\CloseProjectDto;
use App\Dto\v1\Project\CreateContractDto;
use App\Dto\v1\Project\CreateDto;
use App\Dto\v1\Project\UpdateDto;
use App\Dto\v1\Project\UpdatePerformerDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Project\CloseProjectRequest;
use App\Http\Requests\v1\Project\CreateContractRequest;
use App\Http\Requests\v1\Project\CreateRequest;
use App\Http\Requests\v1\Project\UpdatePerformerRequest;
use App\Http\Requests\v1\Project\UpdateRequest;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    /**
     * Summary of index
     * @param \App\Actions\v1\Project\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of show
     * @param int $id
     * @param \App\Actions\v1\Project\ShowAction $action
     * @return JsonResponse
     */
    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\v1\Project\CreateRequest $request
     * @param \App\Actions\v1\Project\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of createContract
     * @param \App\Http\Requests\v1\Project\CreateContractRequest $request
     * @param \App\Actions\v1\Project\CreateContractAction $action
     * @return JsonResponse
     */
    public function createContract(int $id, CreateContractRequest $request, CreateContractAction $action): JsonResponse
    {
        return $action($id, CreateContractDto::from($request));
    }

    public function updatePerformers(int $id, UpdatePerformerRequest $request, UpdatePerformerAction $action): JsonResponse
    {
        return $action($id, UpdatePerformerDto::from($request));
    }

    /**
     * Summary of update
     * @param int $id
     * @param \App\Http\Requests\v1\Project\UpdateRequest $request
     * @param \App\Actions\v1\Project\UpdateAction $action
     * @return JsonResponse
     */
    public function update(int $id, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($id, UpdateDto::from($request));
    }

    /**
     * Summary of closeProject
     * @param int $id
     * @param \App\Http\Requests\v1\Project\CloseProjectRequest $request
     * @param \App\Actions\v1\Project\CloseProjectAction $action
     * @return JsonResponse
     */
    public function closeProject(int $id, CloseProjectRequest $request, CloseProjectAction $action): JsonResponse
    {
        return $action($id, CloseProjectDto::from($request));
    }
}
