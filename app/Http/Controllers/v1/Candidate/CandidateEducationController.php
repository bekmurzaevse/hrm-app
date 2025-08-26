<?php

namespace App\Http\Controllers\v1\Candidate;

use App\Actions\v1\Candidate\Education\AddEducationAction;
use App\Actions\v1\Candidate\Education\DeleteEducationAction;
use App\Actions\v1\Candidate\Education\UpdateEducationAction;
use App\Dto\v1\Candidate\Education\AddEducationDto;
use App\Dto\v1\Candidate\Education\UpdateEducationDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Candidate\Education\AddEducationRequest;
use App\Http\Requests\v1\Candidate\Education\UpdateEducationRequest;
use Illuminate\Http\JsonResponse;

class CandidateEducationController extends Controller
{
    /**
     * Summary of educationCreate
     * @param int $id
     * @param \App\Http\Requests\v1\Candidate\Education\AddEducationRequest $request
     * @param \App\Actions\v1\Candidate\Education\AddEducationAction $action
     * @return JsonResponse
     */
    public function educationCreate(int $id, AddEducationRequest $request, AddEducationAction $action): JsonResponse
    {
        return $action($id, AddEducationDto::from($request));
    }

    /**
     * Summary of educationUpdate
     * @param int $id
     * @param int $educationId
     * @param \App\Http\Requests\v1\Candidate\Education\UpdateEducationRequest $request
     * @param \App\Actions\v1\Candidate\Education\UpdateEducationAction $action
     * @return JsonResponse
     */
    public function educationUpdate(int $id, int $educationId, UpdateEducationRequest $request, UpdateEducationAction $action): JsonResponse
    {
        return $action($id, $educationId, UpdateEducationDto::from($request));
    }

    /**
     * Summary of educationDelete
     * @param int $id
     * @param \App\Actions\v1\Candidate\Education\DeleteEducationAction $action
     * @return JsonResponse
     */
    public function educationDelete(int $id, DeleteEducationAction $action): JsonResponse
    {
        return $action($id);
    }
}
