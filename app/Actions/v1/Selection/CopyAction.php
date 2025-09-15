<?php

namespace App\Actions\v1\Selection;

use App\Dto\v1\Selection\CopyDto;
use App\Exceptions\ApiResponseException;
use App\Models\Selection;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CopyAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Selection\CopyDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, CopyDto $dto): JsonResponse
    {
        DB::beginTransaction();

        try {
            $selection = Selection::with('items.statusValues', 'statuses')->findOrFail($id);
            $newSelection = $selection->replicate();
            $newSelection->title = $dto->title;
            $newSelection->created_by = auth()->id();
            $newSelection->save();

            $itemKeys = [];
            foreach ($selection->items as $item) {
                $newItem = $newSelection->items()->create([
                    'candidate_id' => $item->candidate_id,
                    'external_name' => $item->external_name,
                ]);
                $itemKeys[] = ['old' => $item, 'new' => $newItem];
            }

            $statusKeys = [];
            foreach ($selection->statuses as $status) {
                $newStatus = $newSelection->statuses()->create([
                    'title' => $status->title,
                    'order' => $status->order,
                ]);
                $statusKeys[$status->id] = $newStatus->id;
            }

            // StatusValues copy
            foreach ($itemKeys as $item) {
                $oldItem = $item['old'];
                $newItem = $item['new'];
                $oldStatusValues = $oldItem->statusValues->keyBy('selection_status_id');

                foreach ($statusKeys as $oldStatusId => $newStatusId) {
                    if ($oldStatusValues->has($oldStatusId)) {
                        $newItem->statusValues()->create([
                            'selection_status_id' => $newStatusId,
                            'value' => $oldStatusValues[$oldStatusId]->value,
                        ]);
                    }
                }
            }

            DB::commit();

            return static::toResponse(
                message: 'Selection copied',
            );

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            throw new ApiResponseException("Selection Not Found: ID {$id}", 404);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApiResponseException(
                "Failed to copy selection: " . $e->getMessage(),
                (int) $e->getCode() ?: 500
            );
        }
    }
}