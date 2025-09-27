<?php

namespace App\Http\Controllers\v1\Selection;

use App\Actions\v1\Selection\Status\Value\StoreAction;
use App\Actions\v1\Selection\Status\Value\UpdateAction;
use App\Dto\v1\Selection\Status\Value\StoreDto;
use App\Dto\v1\Selection\Status\Value\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Selection\Status\Value\StoreRequest;
use App\Http\Requests\v1\Selection\Status\Value\UpdateRequest;
use Illuminate\Http\JsonResponse;

class SelectionStatusValueController extends Controller
{
    /**
     * Summary of store
     * @param \App\Actions\v1\Selection\Status\Value\StoreAction $action
     * @param \App\Http\Requests\v1\Selection\Status\Value\StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreAction $action, StoreRequest $request): JsonResponse
    {
        return $action(StoreDto::from($request));
    }

    /**
     * Summary of update
     * @param int $selectionId
     * @param \App\Actions\v1\Selection\Status\Value\UpdateAction $action
     * @param \App\Http\Requests\v1\Selection\Status\Value\UpdateRequest $request
     * @return JsonResponse
     */
    public function update(int $selectionId, int $statusValueId, UpdateAction $action, UpdateRequest $request): JsonResponse
    {
        return $action($selectionId, $statusValueId, UpdateDto::from($request));
    }
}
