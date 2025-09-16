<?php

namespace App\Actions\v1\Selection\StatusValue;

use App\Dto\v1\Selection\StatusValue\StoreDTo;
use App\Exceptions\ApiResponseException;
use App\Models\SelectionStatusValue;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class StoreAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Selection\StatusValue\StoreDTo $dto
     * @return JsonResponse
     */
    public function __invoke(StoreDTo $dto): JsonResponse
    {
        $exists = SelectionStatusValue::where('selection_item_id', $dto->selectionItemId)
            ->where('selection_status_id', $dto->selectionStatusId)
            ->exists();

        if ($exists) {
            throw new ApiResponseException(
                message: 'Selection Status Value already exists',
                code: 409
            );
        }

        SelectionStatusValue::create([
            'selection_item_id' => $dto->selectionItemId,
            'selection_status_id' => $dto->selectionStatusId,
            'value' => $dto->value
        ]);

        return static::toResponse(
            message: 'Selection Status Value created',
        );
    }
}