<?php

namespace App\Http\Controllers\v1\Selection;

use App\Actions\v1\Selection\Status\DeleteAction;
use App\Actions\v1\Selection\Status\ListAction;
use App\Actions\v1\Selection\Status\StoreAction;
use App\Actions\v1\Selection\Status\UpdateAction;
use App\Dto\v1\Selection\Status\StoreDto;
use App\Dto\v1\Selection\Status\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Selection\Status\StoreRequest;
use App\Http\Requests\v1\Selection\Status\UpdateRequest;
use Illuminate\Http\JsonResponse;

class SelectionStatusController extends Controller
{
    /**
     * Summary of list
     * @param int $selectionId
     * @param \App\Actions\v1\Selection\Status\ListAction $action
     * @return JsonResponse
     */
    public function list(int $selectionId, ListAction $action): JsonResponse
    {
        return $action($selectionId);
    }

    /**
     * Summary of store
     * @param int $selectionId
     * @param \App\Http\Requests\v1\Selection\Status\StoreRequest $request
     * @param \App\Actions\v1\Selection\Status\StoreAction $action
     * @return JsonResponse
     */
    public function store(int $selectionId, StoreRequest $request, StoreAction $action): JsonResponse
    {
        return $action($selectionId, StoreDto::from($request));
    }

    /**
     * Summary of update
     * @param int $selectionId
     * @param int $statusId
     * @param \App\Http\Requests\v1\Selection\Status\UpdateRequest $request
     * @param \App\Actions\v1\Selection\Status\UpdateAction $action
     * @return JsonResponse
     */
    public function update(int $selectionId, int $statusId, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($selectionId, $statusId, UpdateDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $selectionId
     * @param int $statusId
     * @param \App\Actions\v1\Selection\Status\DeleteAction $action
     * @return JsonResponse
     */
    public function delete(int $selectionId, int $statusId, DeleteAction $action): JsonResponse
    {
        return $action($selectionId, $statusId);
    }
}
