<?php

namespace App\Actions\v1\Selection\SelectionStatus;

use App\Dto\v1\Selection\SelectionStatus\StoreDto;
use App\Exceptions\ApiResponseException;
use App\Models\Selection;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class StoreAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\v1\Selection\SelectionStatus\StoreDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, StoreDto $dto): JsonResponse
    {
        $selection = Selection::find($id);

        if (!$selection) {
            throw new ApiResponseException('Selection not found', 404);
        }

        if ($selection->created_by !== auth()->id()) {
            throw new ApiResponseException('You are not allowed to access this selection', 403);
        }

        $selection->statuses()->create([
            'title' => $dto->title,
            'order' => $selection->statuses()->max('order') + 1
        ]);
        return static::toResponse(
            message: 'Selection status created',
        );
    }
}