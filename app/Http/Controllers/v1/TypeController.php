<?php

namespace App\Http\Controllers\v1;

use App\Actions\v1\Type\CreateAction;
use App\Actions\v1\Type\DeleteAction;
use App\Actions\v1\Type\IndexAction;
use App\Actions\v1\Type\ListAction;
use App\Actions\v1\Type\ShowAction;
use App\Actions\v1\Type\UpdateAction;
use App\Dto\v1\Type\CreateDto;
use App\Dto\v1\Type\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Type\CreateRequest;
use App\Http\Requests\v1\Type\UpdateRequest;
use Illuminate\Http\JsonResponse;

class TypeController extends Controller
{
    /**
     * Summary of index
     * @param \App\Actions\v1\Type\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of show
     * @param int $id
     * @param \App\Actions\v1\Type\ShowAction $action
     * @return JsonResponse
     */
    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\v1\Type\CreateRequest $request
     * @param \App\Actions\v1\Type\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of update
     * @param int $id
     * @param \App\Http\Requests\v1\Type\UpdateRequest $request
     * @param \App\Actions\v1\Type\UpdateAction $action
     * @return JsonResponse
     */
    public function update(int $id, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($id, UpdateDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $id
     * @param \App\Actions\v1\Type\DeleteAction $action
     * @return JsonResponse
     */
    public function delete(int $id, DeleteAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of list
     * @param \App\Actions\v1\Type\ListAction $action
     * @return JsonResponse
     */
    public function list(ListAction $action): JsonResponse
    {
        return $action();
    }
}
