<?php

namespace App\Http\Controllers\v1\Vacancy;

use App\Actions\v1\Vacancy\Skill\CreateSkillAction;
use App\Actions\v1\Vacancy\Skill\DeleteSkillAction;
use App\Actions\v1\Vacancy\Skill\UpdateSkillAction;
use App\Dto\v1\Vacancy\Skill\CreateSkillDto;
use App\Dto\v1\Vacancy\Skill\UpdateSkillDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Vacancy\Skill\CreateSkillRequest;
use App\Http\Requests\v1\Vacancy\Skill\UpdateSkillRequest;
use Illuminate\Http\JsonResponse;

class VacancySkillController extends Controller
{
    /**
     * Summary of createSkills
     * @param int $id
     * @param \App\Http\Requests\v1\Vacancy\Skill\CreateSkillRequest $request
     * @param \App\Actions\v1\Vacancy\Skill\CreateSkillAction $action
     * @return JsonResponse
     */
    public function createSkills(int $id, CreateSkillRequest $request, CreateSkillAction $action): JsonResponse
    {
        return $action($id, CreateSkillDto::from($request));
    }

    /**
     * Summary of updateSkill
     * @param int $id
     * @param int $skillId
     * @param \App\Http\Requests\v1\Vacancy\Skill\UpdateSkillRequest $request
     * @param \App\Actions\v1\Vacancy\Skill\UpdateSkillAction $action
     * @return JsonResponse
     */
    public function updateSkill(int $id, int $skillId, UpdateSkillRequest $request, UpdateSkillAction $action): JsonResponse
    {
        return $action($id, $skillId, UpdateSkillDto::from($request));
    }

    /**
     * Summary of deleteSkill
     * @param int $id
     * @param int $skillId
     * @param \App\Actions\v1\Vacancy\Skill\DeleteSkillAction $action
     * @return JsonResponse
     */
    public function deleteSkill(int $id, int $skillId, DeleteSkillAction $action): JsonResponse
    {
        return $action($id, $skillId);
    }
}
