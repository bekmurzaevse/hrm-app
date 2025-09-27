<?php

namespace App\Actions\v1\Selection\Status\Value;

use App\Dto\v1\Selection\Status\Value\UpdateDTo;
use App\Exceptions\ApiResponseException;
use App\Models\SelectionStatusValue;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Selection\Status\Value\UpdateDTo $dto
     * @return JsonResponse
     */
    public function __invoke(int $selectionId, int $statusValueId, UpdateDTo $dto): JsonResponse
    {
        $statusValue = SelectionStatusValue::with(['item', 'status'])
            ->find($statusValueId);

        if (!$statusValue) {
            throw new ApiResponseException(
                message: 'Selection Status Value not found',
                code: 404
            );
        }

        $itemSelectionId = $statusValue->item->selection_id;
        $statusSelectionId = $statusValue->status->selection_id;

        if ($selectionId !== $itemSelectionId && $selectionId !== $statusSelectionId) {
            throw new ApiResponseException(
                message: 'Selection Status Value does not belong to this Selection',
                code: 422
            );
        }

        $statusValue->update([
            'value' => $dto->value,
        ]);

        return static::toResponse(
            message: 'Selection Status Value updated',
        );
    }
}
