<?php  

namespace App\Http\Controllers\v1\TaskUser;

use App\Actions\v1\TaskUser\CreateAction;
use App\Actions\v1\TaskUser\DeleteAction;
use App\Actions\v1\TaskUser\IndexAction;
use App\Actions\v1\TaskUser\ShowAction;
use App\Actions\v1\TaskUser\UpdateAction;
use App\Dto\v1\TaskUser\CreateDto;
use App\Dto\v1\TaskUser\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\TaskUser\CreateRequest;
use App\Http\Requests\v1\TaskUser\UpdateRequest;
use Illuminate\Http\JsonResponse;
use Js;

class TaskUserController extends Controller
{

    /**
     * Summary of index
     * @param \App\Actions\v1\TaskUser\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of show
     * @param \App\Actions\v1\TaskUser\ShowAction $action
     * @param int $id
     * @return JsonResponse
     */
    public function show(ShowAction $action, int $id): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\v1\TaskUser\CreateRequest $request
     * @param \App\Actions\v1\TaskUser\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\v1\TaskUser\UpdateRequest $request
     * @param \App\Actions\v1\TaskUser\UpdateAction $action
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, UpdateAction $action, int $id): JsonResponse
    {
        return $action($id, UpdateDto::from($request));
    }

    /**
     * Summary of delete
     * @param \App\Actions\v1\TaskUser\DeleteAction $action
     * @param int $id
     * @return JsonResponse
     */
    public function delete(DeleteAction $action, int $id): JsonResponse
    {
        return $action($id);
    }
}