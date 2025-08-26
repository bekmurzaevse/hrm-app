<?php

namespace App\Http\Controllers\v1\Candidate;

use App\Actions\v1\Candidate\Contact\AddContactAction;
use App\Actions\v1\Candidate\Contact\DeleteContactAction;
use App\Actions\v1\Candidate\Contact\UpdateContactAction;
use App\Dto\v1\Candidate\Contact\AddContactDto;
use App\Dto\v1\Candidate\Contact\UpdateContactDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Candidate\Contact\AddContactRequest;
use App\Http\Requests\v1\Candidate\Contact\UpdateContactRequest;
use Illuminate\Http\JsonResponse;

class CandidateContactController extends Controller
{
    /**
     * Summary of contactCreate
     * @param int $id
     * @param \App\Http\Requests\v1\Candidate\Contact\AddContactRequest $request
     * @param \App\Actions\v1\Candidate\Contact\AddContactAction $action
     * @return JsonResponse
     */
    public function contactCreate(int $id, AddContactRequest $request, AddContactAction $action): JsonResponse
    {
        return $action($id, AddContactDto::from($request));
    }

    /**
     * Summary of contactUpdate
     * @param int $id
     * @param int $contactId
     * @param \App\Http\Requests\v1\Candidate\Contact\UpdateContactRequest $request
     * @param \App\Actions\v1\Candidate\Contact\UpdateContactAction $action
     * @return JsonResponse
     */
    public function contactUpdate(int $id, int $contactId, UpdateContactRequest $request, UpdateContactAction $action): JsonResponse
    {
        return $action($id, $contactId, UpdateContactDto::from($request));
    }

    /**
     * Summary of contactUDelete
     * @param int $id
     * @param int $contactId
     * @param \App\Actions\v1\Candidate\Contact\DeleteContactAction $action
     * @return JsonResponse
     */
    public function contactUDelete(int $id, int $contactId, DeleteContactAction $action): JsonResponse
    {
        return $action($id, $contactId);
    }
}
