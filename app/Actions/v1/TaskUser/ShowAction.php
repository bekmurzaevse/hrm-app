<?php 

namespace App\Actions\v1\TaskUser;

use App\Exceptions\ApiResponseException;
use App\Http\Resources\v1\TaskUser\TaskUserResource;
use App\Models\TaskUser;
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
            $key = 'task_users:show:' . app()->getLocale() . ':' . md5(request()->fullUrl());
            $taskUser = Cache::remember($key, now()->addDay(), function () use ($id) {
                return TaskUser::with(['task', 'user'])->findOrFail($id);
            });

            return static::toResponse(
                message: "$id - id li task user mag'liwmatlari",
                data: new TaskUserResource($taskUser)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task User Not Found', 404);
        }
    }
}