<?php

namespace App\Actions\v1\Project;

use App\Exceptions\ApiResponseException;
use App\Models\Stage;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class SetRequireStageAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Project\UpdateStageDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $stageId): JsonResponse
    {
        try {
            $stage = Stage::findOrFail($stageId);

            if ($stage->is_required === false) {
                $stage->is_required = true;
                $stage->save();
            } else {
                return static::toResponse(
                    message: 'Stage already marked as required'
                );
            }

            return static::toResponse(
                message: 'Stage marked as required'
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException("Stage Not Found", 404);
        }
    }
}
