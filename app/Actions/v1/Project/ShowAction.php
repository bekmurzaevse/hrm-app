<?php

namespace App\Actions\v1\Project;

use App\Exceptions\ApiResponseException;
use App\Http\Resources\v1\Project\ProjectResource;
use App\Models\Project;
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
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $key = 'projects:show:' . app()->getLocale() . ':' . md5(request()->fullUrl());
            $vacnacy = Cache::remember($key, now()->addDay(), function () use ($id) {
                return Project::with([
                    'stages.executor',
                    'stages.stageTasks',
                    'stages.stageTasks.executor',
                ])->findOrFail($id);
            });

            return static::toResponse(
                message: 'Successfully received',
                data: new ProjectResource($vacnacy)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Project Not Found', 404);
        }
    }
}
