<?php

namespace App\Actions\v1\TaskUser;

use App\Exceptions\ApiResponseException;
use App\Models\TaskUser;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteAction
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
            $taskUser = TaskUser::findOrFail($id);
            $taskUser->delete();

            logActivity(
                "Пользователь удален из задачи",
                "Пользователь " . auth()->user()->first_name . ' ' . auth()->user()->last_name . " удален из задачи ID: {$taskUser->task_id}"
            );

            return static::toResponse(
                message: 'Task User deleted successfully',
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task User Not Found', 404);
        }
    }
}
