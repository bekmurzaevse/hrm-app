<?php

namespace App\Actions\v1\Candidate\Skill;

use App\Dto\v1\Candidate\Skill\AddSkillDto;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class AddSkillAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\v1\Candidate\Skill\AddSkillDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, AddSkillDto $dto): JsonResponse
    {
        $candidate = Candidate::findOrFail($id);

        $addedSkills = [];

        array_map(function ($title) use ($candidate) {
            $candidate->skills()->create([
                'title' => $title,
            ]);
            $addedSkills[] = $title;
        }, $dto->titles);

        $skillsString = implode(', ', $addedSkills);

        logActivity(
            "Навыки добавлены!",
            "Кандидату с $candidate->first_name $candidate->last_name добавлены навыки: {$skillsString}."
        );

        return static::toResponse(
            message: 'Skills added!'
        );
    }
}
