<?php

namespace App\Actions\v1\Selection\Status;

use App\Exceptions\ApiResponseException;
use App\Models\Selection;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class DeleteAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param int $statusId
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, int $statusId): JsonResponse
    {
        $selection = Selection::find($id);

        if (!$selection) {
            throw new ApiResponseException('Selection not found', 404);
        }

        if ($selection->created_by !== auth()->id()) {
            throw new ApiResponseException('You are not allowed to access this selection', 403);
        }

        $status = $selection->statuses()->find($statusId);

        if (!$status) {
            throw new ApiResponseException('Status not found', 404);
        }
        $order = $status->order;

        $status->delete();

        $selection->statuses()
            ->where('order', '>', $order)
            ->decrement('order');

        return static::toResponse(
            message: 'Selection status deleted',
        );
    }
}
