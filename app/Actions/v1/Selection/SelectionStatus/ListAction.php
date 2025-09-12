<?php

namespace App\Actions\v1\Selection\SelectionStatus;

use App\Exceptions\ApiResponseException;
use App\Models\Selection;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ListAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $selectionId
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $selectionId): JsonResponse
    {
        $selection = Selection::find($selectionId);

        if (!$selection) {
            throw new ApiResponseException('Selection not found', 404);
        }

        if ($selection->created_by !== auth()->id()) {
            throw new ApiResponseException('You are not allowed to access this selection', 403);
        }

        $key = 'selection_statuses:list:' . auth()->id() . ':' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $selection_statuses = Cache::remember($key, now()->addDay(), function () use ($selection) {
            return $selection->statuses()
                ->select('id', 'title')
                ->get();
        });

        return static::toResponse(
            message: 'Successfully received',
            data: $selection_statuses->toArray()
        );
    }
}