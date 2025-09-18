<?php

namespace App\Http\Controllers\v1\Vacancy;

use App\Actions\v1\Vacancy\Skill\CreateAction;
use App\Actions\v1\Vacancy\Skill\DeleteAction;
use App\Actions\v1\Vacancy\Skill\UpdateAction;
use App\Dto\v1\Vacancy\Skill\CreateDto;
use App\Dto\v1\Vacancy\Skill\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Vacancy\Skill\CreateRequest;
use App\Http\Requests\v1\Vacancy\Skill\UpdateRequest;
use Illuminate\Http\JsonResponse;

class VacancySkillController extends Controller
{
    /**
     * Summary of createSkills
     * @param int $id
     * @param \App\Http\Requests\v1\Vacancy\Skill\CreateRequest $request
     * @param \App\Actions\v1\Vacancy\Skill\CreateAction $action
     * @return JsonResponse
     */
    public function createSkills(int $id, CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action($id, CreateDto::from($request));
    }

    /**
     * Summary of updateSkill
     * @param int $id
     * @param int $skillId
     * @param \App\Http\Requests\v1\Vacancy\Skill\UpdateRequest $request
     * @param \App\Actions\v1\Vacancy\Skill\UpdateAction $action
     * @return JsonResponse
     */
    public function updateSkill(int $id, int $skillId, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($id, $skillId, UpdateDto::from($request));
    }

    /**
     * Summary of deleteSkill
     * @param int $id
     * @param int $skillId
     * @param \App\Actions\v1\Vacancy\Skill\DeleteAction $action
     * @return JsonResponse
     */
    public function deleteSkill(int $id, int $skillId, DeleteAction $action): JsonResponse
    {
        return $action($id, $skillId);
    }
}
