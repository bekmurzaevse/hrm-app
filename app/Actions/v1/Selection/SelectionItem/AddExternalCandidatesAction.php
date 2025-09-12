<?php

namespace App\Actions\v1\Selection\SelectionItem;

use App\Dto\v1\Selection\SelectionItem\AddExternalCandidatesDto;
use App\Exceptions\ApiResponseException;
use App\Models\Selection;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class AddExternalCandidatesAction
{
    use ResponseTrait;
    public function __invoke(int $id, AddExternalCandidatesDto $dto): JsonResponse
    {
        try {
            $selection = Selection::where('id', $id)
                ->where('created_by', auth()->id())
                ->firstOrFail();

            $items = collect($dto->externalCandidates)
                ->map(fn($name) => [
                    'selection_id' => $selection->id,
                    'candidate_id' => null,
                    'external_name' => trim($name),
                ])
                ->toArray();
            $selection->items()->insert($items);

            if (count($items) == 1) {
                $message = 'External Candidate added to selection';
            } else {
                $message = 'External Candidates added to selections';
            }

            return static::toResponse(
                message: $message,
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Selection Not Found', 404);
        }
    }
}