<?php

namespace App\Http\Controllers\v1\Selection;

use App\Actions\v1\Selection\StatusValue\StoreAction;
use App\Actions\v1\Selection\StatusValue\UpdateAction;
use App\Dto\v1\Selection\StatusValue\StoreDto;
use App\Dto\v1\Selection\StatusValue\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Selection\StatusValue\StoreRequest;
use App\Http\Requests\v1\Selection\StatusValue\UpdateRequest;
use Illuminate\Http\JsonResponse;

class SelectionStatusValueController extends Controller
{
    /**
     * Summary of store
     * @param \App\Actions\v1\Selection\StatusValue\StoreAction $action
     * @param \App\Http\Requests\v1\Selection\StatusValue\StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreAction $action, StoreRequest $request): JsonResponse
    {
        return $action(StoreDto::from($request));
    }

    /**
     * Summary of update
     * @param int $selectionId
     * @param \App\Actions\v1\Selection\StatusValue\UpdateAction $action
     * @param \App\Http\Requests\v1\Selection\StatusValue\UpdateRequest $request
     * @return JsonResponse
     */
    public function update(int $selectionId, int $statusValueId, UpdateAction $action, UpdateRequest $request): JsonResponse
    {
        return $action($selectionId, $statusValueId, UpdateDto::from($request));
    }
}