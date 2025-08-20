<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\UpdateSkillDto;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class UpdateSkillAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param int $skillId
     * @param \App\Dto\Candidate\UpdateSkillDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, int $skillId, UpdateSkillDto $dto): JsonResponse
    {
        $candidate = Candidate::findOrFail($id);

        $skill = $candidate->skills()->where('id', $skillId)->firstOrFail();

        $oldData = $skill->only(['title']);

        $skill->update([
            'title' => $dto->title,
        ]);

        logActivity(
        "Навык обновлён!",
        "У кандидата $candidate->first_name $candidate->last_name был обновлён навык $skill->title).
            Старые данные: " . json_encode($oldData, JSON_UNESCAPED_UNICODE) .
            " | Новые данные: " . json_encode([
            'title' => $dto->title,
            ], JSON_UNESCAPED_UNICODE)
        );

        return static::toResponse(
            message: 'Skills updated!'
        );
    }
}
