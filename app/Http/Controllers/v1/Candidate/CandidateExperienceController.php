<?php

namespace App\Http\Controllers\v1\Candidate;

use App\Actions\v1\Candidate\Experience\AddExperienceAction;
use App\Actions\v1\Candidate\Experience\DeleteExperienceAction;
use App\Actions\v1\Candidate\Experience\UpdateExperienceAction;
use App\Dto\v1\Candidate\Experience\AddExperienceDto;
use App\Dto\v1\Candidate\Experience\UpdateExperienceDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Candidate\Experience\AddWorkExperienceRequest;
use App\Http\Requests\v1\Candidate\Experience\UpdateWorkExperienceRequest;
use Illuminate\Http\JsonResponse;

class CandidateExperienceController extends Controller
{
    /**
     * Summary of experienceCreate
     * @param int $id
     * @param \App\Http\Requests\v1\Candidate\Experience\AddWorkExperienceRequest $request
     * @param \App\Actions\v1\Candidate\Experience\AddExperienceAction $action
     * @return JsonResponse
     */
    public function experienceCreate(int $id, AddWorkExperienceRequest $request, AddExperienceAction $action): JsonResponse
    {
        return $action($id, AddExperienceDto::from($request));
    }

    /**
     * Summary of experienceUpdate
     * @param int $id
     * @param int $workId
     * @param \App\Http\Requests\v1\Candidate\Experience\UpdateWorkExperienceRequest $request
     * @param \App\Actions\v1\Candidate\Experience\UpdateExperienceAction $action
     * @return JsonResponse
     */
    public function experienceUpdate(int $id, int $workId, UpdateWorkExperienceRequest $request, UpdateExperienceAction $action): JsonResponse
    {
        return $action($id, $workId, UpdateExperienceDto::from($request));
    }

    /**
     * Summary of experienceDelete
     * @param int $id
     * @param \App\Actions\v1\Candidate\Experience\DeleteExperienceAction $action
     * @return JsonResponse
     */
    public function experienceDelete(int $id, DeleteExperienceAction $action): JsonResponse
    {
        return $action($id);
    }
}
