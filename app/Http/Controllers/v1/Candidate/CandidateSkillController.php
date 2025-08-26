<?php

namespace App\Http\Controllers\v1\Candidate;

use App\Actions\v1\Candidate\Skill\AddSkillAction;
use App\Actions\v1\Candidate\Skill\DeleteSkillAction;
use App\Actions\v1\Candidate\Skill\UpdateSkillAction;
use App\Dto\v1\Candidate\Skill\AddSkillDto;
use App\Dto\v1\Candidate\Skill\UpdateSkillDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Candidate\Skill\AddSkillRequest;
use App\Http\Requests\v1\Candidate\Skill\UpdateSkillRequest;
use Illuminate\Http\JsonResponse;

class CandidateSkillController extends Controller
{
    /**
     * Summary of skillCreate
     * @param int $id
     * @param \App\Http\Requests\v1\Candidate\Skill\AddSkillRequest $request
     * @param \App\Actions\v1\Candidate\Skill\AddSkillAction $action
     * @return JsonResponse
     */
    public function skillCreate(int $id, AddSkillRequest $request, AddSkillAction $action): JsonResponse
    {
        return $action($id, AddSkillDto::from($request));
    }

    /**
     * Summary of skillUpdate
     * @param int $id
     * @param int $skillId
     * @param \App\Http\Requests\v1\Candidate\Skill\UpdateSkillRequest $request
     * @param \App\Actions\v1\Candidate\Skill\UpdateSkillAction $action
     * @return JsonResponse
     */
    public function skillUpdate(int $id, int $skillId, UpdateSkillRequest $request, UpdateSkillAction $action): JsonResponse
    {
        return $action($id, $skillId, UpdateSkillDto::from($request));
    }

    /**
     * Summary of skillDelete
     * @param int $id
     * @param int $skillId
     * @param \App\Actions\v1\Candidate\Skill\DeleteSkillAction $action
     * @return JsonResponse
     */
    public function skillDelete(int $id, int $skillId, DeleteSkillAction $action): JsonResponse
    {
        return $action($id, $skillId);
    }
}
