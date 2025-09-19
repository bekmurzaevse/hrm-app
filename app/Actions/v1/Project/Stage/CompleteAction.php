<?php

namespace App\Actions\v1\Project\Stage;

use App\Dto\v1\Project\Stage\CompleteDto;
use App\Enums\StageStatusEnum;
use App\Exceptions\ApiResponseException;
use App\Models\Stage;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CompleteAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $stageId
     * @param \App\Dto\v1\Project\Stage\CompleteDto $dto
     * @return JsonResponse
     * @throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $stageId, CompleteDto $dto): JsonResponse
    {
        try {
            $stage = Stage::findOrFail($stageId);

            if ($stage->status === StageStatusEnum::IN_PROGRESS) {
                $stage->stageCompletion()->create([
                    'completed_by' => auth()->id(),
                    'candidate_count' => $dto->candidateCount,
                    'comment' => $dto->comment
                ]);

                $stage->status = StageStatusEnum::COMPLETED;
                $stage->save();

                $projectId = $stage->project_id;

                // Mark next stage as in_progress
                $afterStage = Stage::where('project_id', $projectId)
                    ->where('order', '>', $stage->order)
                    ->orderBy('order', 'asc')
                    ->first();
                $afterStage->status = StageStatusEnum::IN_PROGRESS;
                $afterStage->save();

                // Log user activity
                $title = 'Завершение этапа';
                $text = "Этап «{$stage->title}» проекта «{$stage->project->title}» был завершён";
                logActivity($title, $text);
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
