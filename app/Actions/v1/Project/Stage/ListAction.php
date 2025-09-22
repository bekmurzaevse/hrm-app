<?php

namespace App\Actions\v1\Project\Stage;

use App\Enums\StageStatusEnum;
use App\Models\Stage;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ListAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $stages = Stage::where('project_id', $id)->whereNot('status', StageStatusEnum::COMPLETED)->get()->map(function ($stage) {
            return [
                'id' => $stage->id,
                'title' => $stage->title,
            ];
        });

        return static::toResponse(
            message: "Project's Stage list",
            data: $stages
        );
    }
}
