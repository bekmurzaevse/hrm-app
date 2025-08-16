<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\AddSkillDto;
use App\Dto\Candidate\UpdateSkillDto;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class UpdateSkillAction
{
    use ResponseTrait;

    public function __invoke(int $id, int $skillId, UpdateSkillDto $dto): JsonResponse
    {
        $candidate = Candidate::findOrFail($id);

        $candidate->skills()->where('id', $skillId)->first()->update(['title' => $dto->title]);
        // array_map(function ($title) use ($candidate) {
        //     $candidate->skills()->create([
        //         'title' => $title,
        //     ]);
        // }, $dto->titles);

        return static::toResponse(
            message: 'Skills updated!'
        );
    }
}
