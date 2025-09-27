<?php

namespace App\Http\Controllers\v1\Selection;

use App\Actions\v1\Selection\Item\AddExternalCandidatesAction;
use App\Actions\v1\Selection\Item\AttachCandidatesAction;
use App\Actions\v1\Selection\Item\DetachCandidatesAction;
use App\Dto\v1\Selection\Item\AddExternalCandidatesDto;
use App\Dto\v1\Selection\Item\AttachCandidatesDto;
use App\Dto\v1\Selection\Item\DetachCandidatesDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Selection\Item\AddExternalCandidatesRequest;
use App\Http\Requests\v1\Selection\Item\AttachCandidatesRequest;
use App\Http\Requests\v1\Selection\Item\DetachCandidatesRequest;
use Illuminate\Http\JsonResponse;

class SelectionItemController extends Controller
{
    /**
     * Summary of attachCandidatess
     * @param \App\Http\Requests\v1\Selection\Item\AttachCandidatesRequest $request
     * @param \App\Actions\v1\Selection\Item\AttachCandidatesAction $action
     * @return JsonResponse
     */
    public function attachCandidates(AttachCandidatesRequest $request, AttachCandidatesAction $action): JsonResponse
    {
        return $action(AttachCandidatesDto::from($request));
    }

    /**
     * Summary of detachCandidates
     * @param \App\Http\Requests\v1\Selection\Item\DetachCandidatesRequest $request
     * @param \App\Actions\v1\Selection\Item\DetachCandidatesAction $action
     * @return JsonResponse
     */
    public function detachCandidates(int $id, DetachCandidatesRequest $request, DetachCandidatesAction $action): JsonResponse
    {
        return $action($id, DetachCandidatesDto::from($request));
    }

    /**
     * Summary of addExternalCandidates
     * @param int $id
     * @param \App\Http\Requests\v1\Selection\Item\AddExternalCandidatesRequest $request
     * @param \App\Actions\v1\Selection\Item\AddExternalCandidatesAction $action
     * @return JsonResponse
     */
    public function addExternalCandidates(int $id, AddExternalCandidatesRequest $request, AddExternalCandidatesAction $action): JsonResponse
    {
        return $action($id, AddExternalCandidatesDto::from($request));
    }
}
