<?php

namespace App\Http\Controllers\v1\Selection;

use App\Actions\v1\Selection\SelectionItem\AddExternalCandidatesAction;
use App\Actions\v1\Selection\SelectionItem\AttachCandidatesAction;
use App\Actions\v1\Selection\SelectionItem\DetachCandidatesAction;
use App\Dto\v1\Selection\SelectionItem\AddExternalCandidatesDto;
use App\Dto\v1\Selection\SelectionItem\AttachCandidatesDto;
use App\Dto\v1\Selection\SelectionItem\DetachCandidatesDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Selection\SelectionItem\AddExternalCandidatesRequest;
use App\Http\Requests\v1\Selection\SelectionItem\AttachCandidatesRequest;
use App\Http\Requests\v1\Selection\SelectionItem\DetachCandidatesRequest;
use Illuminate\Http\JsonResponse;

class SelectionItemController extends Controller
{
    /**
     * Summary of attachCandidatess
     * @param \App\Http\Requests\v1\Selection\SelectionItem\AttachCandidatesRequest $request
     * @param \App\Actions\v1\Selection\SelectionItem\AttachCandidatesAction $action
     * @return JsonResponse
     */
    public function attachCandidates(AttachCandidatesRequest $request, AttachCandidatesAction $action): JsonResponse
    {
        return $action(AttachCandidatesDto::from($request));
    }

    /**
     * Summary of detachCandidates
     * @param \App\Http\Requests\v1\Selection\SelectionItem\DetachCandidatesRequest $request
     * @param \App\Actions\v1\Selection\SelectionItem\DetachCandidatesAction $action
     * @return JsonResponse
     */
    public function detachCandidates(int $id, DetachCandidatesRequest $request, DetachCandidatesAction $action): JsonResponse
    {
        return $action($id, DetachCandidatesDto::from($request));
    }

    /**
     * Summary of addExternalCandidates
     * @param int $id
     * @param \App\Http\Requests\v1\Selection\SelectionItem\AddExternalCandidatesRequest $request
     * @param \App\Actions\v1\Selection\SelectionItem\AddExternalCandidatesAction $action
     * @return JsonResponse
     */
    public function addExternalCandidates(int $id, AddExternalCandidatesRequest $request, AddExternalCandidatesAction $action): JsonResponse
    {
        return $action($id, AddExternalCandidatesDto::from($request));
    }
}