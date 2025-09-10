<?php

namespace App\Http\Controllers\v1\Selection;

use App\Actions\v1\Selection\SelectionItem\AddExternalCandidatesAction;
use App\Actions\v1\Selection\SelectionItem\AttachCandidateAction;
use App\Actions\v1\Selection\SelectionItem\DetachCandidateAction;
use App\Dto\v1\Selection\SelectionItem\AddExternalCandidatesDto;
use App\Dto\v1\Selection\SelectionItem\AttachCandidateDto;
use App\Dto\v1\Selection\SelectionItem\DetachCandidateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Selection\SelectionItem\AddExternalCandidatesRequest;
use App\Http\Requests\v1\Selection\SelectionItem\AttachCandidateRequest;
use App\Http\Requests\v1\Selection\SelectionItem\DetachCandidateRequest;
use Illuminate\Http\JsonResponse;

class SelectionItemController extends Controller
{
    /**
     * Summary of attachCandidates
     * @param \App\Http\Requests\v1\Selection\SelectionItem\AttachCandidateRequest $request
     * @param \App\Actions\v1\Selection\SelectionItem\AttachCandidateAction $action
     * @return JsonResponse
     */
    public function attachCandidates(AttachCandidateRequest $request, AttachCandidateAction $action): JsonResponse
    {
        return $action(AttachCandidateDto::from($request));
    }

    /**
     * Summary of detachCandidates
     * @param \App\Http\Requests\v1\Selection\SelectionItem\DetachCandidateRequest $request
     * @param \App\Actions\v1\Selection\SelectionItem\DetachCandidateAction $action
     * @return JsonResponse
     */
    public function detachCandidates(int $id, DetachCandidateRequest $request, DetachCandidateAction $action): JsonResponse
    {
        return $action($id, DetachCandidateDto::from($request));
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