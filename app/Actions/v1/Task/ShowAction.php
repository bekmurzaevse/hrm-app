<?php

namespace App\Actions\v1\Task;

use App\Exceptions\ApiResponseException;
use App\Http\Resources\v1\Task\TaskResource;
use App\Models\Task;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ShowAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @return JsonResponse
     * @throws ApiResponseException
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $key = 'tasks:show:' . app()->getLocale() . ':' . md5(request()->fullUrl());
            $task = Cache::remember($key, now()->addDay(), function () use ($id) {
                return Task::with(['createdBy'])->findOrFail($id);
            });

            return static::toResponse(
                message: "$id - id li task mag'liwmatlari",
                data: new TaskResource($task)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task Not Found', 404);
        }
    }
}