<?php

namespace App\Actions\v1\Selection\SelectionItem;

use App\Dto\v1\Selection\SelectionItem\DetachCandidateDto;
use App\Exceptions\ApiResponseException;
use App\Models\Selection;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DetachCandidateAction
{
    use ResponseTrait;

    public function __invoke($id, DetachCandidateDto $dto): JsonResponse
    {
        try {
            $selection = Selection::findOrFail($id);

            $foundIds = $selection->items()
                ->whereIn('id', $dto->items)
                ->pluck('id')
                ->toArray();

            if (count($foundIds) !== count($dto->items)) {
                $missing = array_diff($dto->items, $foundIds);
                throw new ApiResponseException(
                    'Some items not found: ' . implode(',', $missing),
                    404
                );
            }

            $selection->items()
                ->whereIn('id', $dto->items)
                ->delete();

            return static::toResponse(
                message: 'Candidates detached from selection',
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Selection Not Found', 404);
        }
    }
}