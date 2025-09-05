<?php

namespace App\Http\Controllers\v1\Selection;

use App\Actions\v1\Selection\CreateAction;
use App\Actions\v1\Selection\DeleteAction;
use App\Actions\v1\Selection\DeleteManyAction;
use App\Actions\v1\Selection\IndexAction;
use App\Dto\v1\Selection\CreateDto;
use App\Dto\v1\Selection\DeleteManyDto;
use App\Dto\v1\Selection\IndexDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Selection\CreateRequest;
use App\Http\Requests\v1\Selection\DeleteManyRequest;
use App\Http\Requests\v1\Selection\IndexRequest;
use Illuminate\Http\JsonResponse;

class SelectionController extends Controller
{
    /**
     * Summary of index
     * @param \App\Http\Requests\v1\Selection\IndexRequest $request
     * @param \App\Actions\v1\Selection\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexRequest $request, IndexAction $action): JsonResponse
    {
        return $action(IndexDto::from($request));
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\v1\Selection\CreateRequest $request
     * @param \App\Actions\v1\Selection\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $id
     * @param \App\Actions\v1\Selection\DeleteAction $action
     * @return JsonResponse
     */
    public function delete(int $id, DeleteAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of deleteMany
     * @param \App\Http\Requests\v1\Selection\DeleteManyRequest $request
     * @param \App\Actions\v1\Selection\DeleteManyAction $action
     * @return JsonResponse
     */
    public function deleteMany(DeleteManyRequest $request, DeleteManyAction $action): JsonResponse
    {
        return $action(DeleteManyDto::from($request));
    }
}
