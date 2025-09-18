<?php

namespace App\Http\Controllers\v1\Client;

use App\Actions\v1\Client\CreateAction;
use App\Actions\v1\Client\DeleteAction;
use App\Actions\v1\Client\IndexAction;
use App\Actions\v1\Client\ListAction;
use App\Actions\v1\Client\ShowAction;
use App\Actions\v1\Client\UpdateAction;
use App\Dto\v1\Client\CreateDto;
use App\Dto\v1\Client\IndexDto;
use App\Dto\v1\Client\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Client\CreateRequest;
use App\Http\Requests\v1\Client\IndexRequest;
use App\Http\Requests\v1\Client\UpdateRequest;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    /**
     * Summary of index
     * @param \App\Actions\v1\Client\IndexAction $action
     * @param \App\Http\Requests\v1\Client\IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexAction $action, IndexRequest $request): JsonResponse
    {
        return $action(IndexDto::from($request));
    }

    public function list(ListAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of show
     * @param int $id
     * @param \App\Actions\v1\Client\ShowAction $action
     * @return JsonResponse
     */
    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\v1\Client\CreateRequest $request
     * @param \App\Actions\v1\Client\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of update
     * @param int $id
     * @param \App\Http\Requests\v1\Client\UpdateRequest $request
     * @param \App\Actions\v1\Client\UpdateAction $action
     * @return JsonResponse
     */
    public function update(int $id, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($id, UpdateDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $id
     * @param \App\Actions\v1\Client\DeleteAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id, DeleteAction $action): JsonResponse
    {
        return $action($id);
    }
}
