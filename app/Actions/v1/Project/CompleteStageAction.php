<?php

namespace App\Actions\v1\Project;

use App\Dto\Project\CompleteStageDto;
use App\Exceptions\ApiResponseException;
use App\Models\Stage;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CompleteStageAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $stageId
     * @param \App\Dto\Project\CompleteStageDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $stageId, CompleteStageDto $dto): JsonResponse
    {
        try {
            $stage = Stage::findOrFail($stageId);

            if ($stage->status === 'В работе') {
                $stage->stageCompletion()->create([
                    'completed_by' => 1, // TODO: add auth user
                    'candidate_count' => $dto->candidateCount,
                    'comment' => $dto->comment
                ]);

                $stage->status = 'completed';
                $stage->save();

                $projectId = $stage->project_id;


                // Mark next stage as in_progress
                $afterStage = Stage::where('project_id', $projectId)
                    ->where('order', '>', $stage->order)
                    ->orderBy('order', 'asc')
                    ->first();
                $afterStage->status = 'in_progress';
                $afterStage->save();
            } else {
                return static::toResponse(
                    message: "Stage status need in_progress, now it is {$stage->status}"
                );
            }

            return static::toResponse(
                message: 'Stage completed'
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException("Stage Not Found", 404);
        }
    }
}
