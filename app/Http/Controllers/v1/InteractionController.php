<?php

namespace App\Http\Controllers\v1;

use App\Actions\v1\Interaction\CreateAction;
use App\Actions\v1\Interaction\DeleteAction;
use App\Actions\v1\Interaction\IndexAction;
use App\Actions\v1\Interaction\ShowAction;
use App\Actions\v1\Interaction\UpdateAction;
use App\Dto\Interaction\CreateDto;
use App\Dto\Interaction\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Interaction\CreateRequest;
use App\Http\Requests\v1\Interaction\UpdateRequest;
use Illuminate\Http\JsonResponse;

class InteractionController extends Controller
{

    /**
     * Summary of index
     * @param \App\Actions\v1\Interaction\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of show
     * @param int $id
     * @param \App\Actions\v1\Interaction\ShowAction $action
     * @return JsonResponse
     */
    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\v1\Interaction\CreateRequest $request
     * @param \App\Actions\v1\Interaction\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of update
     * @param int $id
     * @param \App\Http\Requests\v1\Interaction\UpdateRequest $request
     * @param \App\Actions\v1\Interaction\UpdateAction $action
     * @return JsonResponse
     */
    public function update(int $id, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($id, UpdateDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $id
     * @param \App\Actions\v1\Interaction\DeleteAction $action
     * @return JsonResponse
     */
    public function delete(int $id, DeleteAction $action): JsonResponse
    {
        return $action($id);
    }
}
