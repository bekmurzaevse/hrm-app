<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\AddSkillDto;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class AddSkillAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\Candidate\AddSkillDto $dto
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
            "Кандидату с ID {$candidate->id} добавлены навыки: {$skillsString}."
        );

        return static::toResponse(
            message: 'Skills added!'
        );
    }
}
