<?php

namespace App\Actions\v1\User;

use App\Exceptions\ApiResponseException;
use App\Http\Resources\v1\User\UserResource;
use App\Models\User;
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
            $key = 'users:show:' . app()->getLocale() . ':' . md5(request()->fullUrl());
            $user = Cache::remember($key, now()->addDay(), function () use ($id) {
                return User::with([
                    'activities',
                    'projects.stages',
                    'projects.performers',
                    'projects.stages.executor',
                    'projects.client',
                    'projects.vacancy',
                    ])->findOrFail($id);
            });

            return static::toResponse(
                message: 'Successfully received',
                data: new UserResource($user)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('User Not Found', 404);
        }
    }
}
