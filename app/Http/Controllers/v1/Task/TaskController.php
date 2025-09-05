<?php

namespace App\Http\Controllers\v1\Task;

use App\Actions\v1\Task\CreateAction;
use App\Actions\v1\Task\DeleteAction;
use App\Actions\v1\Task\IndexAction;
use App\Actions\v1\Task\ShowAction;
use App\Actions\v1\Task\UpdateAction;
use App\Dto\v1\Task\CreateDto;
use App\Dto\v1\Task\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Task\CreateRequest;
use App\Http\Requests\v1\Task\UpdateRequest;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{

    /**
     * Summary of index
     * @param \App\Actions\v1\Task\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of show
     * @param int $id
     * @param \App\Actions\v1\Task\ShowAction $action
     * @return JsonResponse
     */
    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\v1\Task\CreateRequest $request
     * @param \App\Actions\v1\Task\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of update
     * @param int $id
     * @param \App\Http\Requests\v1\Task\UpdateRequest $request
     * @param \App\Actions\v1\Task\UpdateAction $action
     * @return JsonResponse
     */
    public function update(int $id, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($id, UpdateDto::from($request));
    }

    /**
     * Summary of destroy
     * @param int $id
     * @param \App\Actions\v1\Task\DeleteAction $action
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteAction $action): JsonResponse
    {
        return $action($id);
    }
}