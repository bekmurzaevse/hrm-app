<?php

namespace App\Actions\v1\Selection;

use App\Exceptions\ApiResponseException;
use App\Http\Resources\v1\Selection\SelectionResource;
use App\Models\Selection;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ShowAction
{
    use ResponseTrait;

    public function __invoke(int $id): JsonResponse
    {
        try {
            $key = 'selections:show:' . auth()->user()->id . ':' . app()->getLocale() . ':' . md5(request()->fullUrl());
            $selection = Cache::remember($key, now()->addDay(), function () use ($id) {
                return Selection::with([
                    'createdBy',
                    'items.candidate',
                    'items.statusValues',
                    'statuses',
                ])
                    ->where('created_by', auth()->user()->id)
                    ->findOrFail($id);
            });

            return static::toResponse(
                message: 'Successfully received',
                data: new SelectionResource($selection)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Selection Not Found', 404);
        }
    }
}