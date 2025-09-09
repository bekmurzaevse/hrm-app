<?php

namespace App\Http\Controllers\v1\Selection;

use App\Actions\v1\Selection\SelectionItem\AttachCandidateAction;
use App\Dto\v1\Selection\SelectionItem\AttachCandidateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Selection\SelectionItem\AttachCandidateRequest;
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
}