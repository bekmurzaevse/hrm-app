<?php

namespace App\Actions\v1\Task;

use App\Exceptions\ApiResponseException;
use App\Models\Task;
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
    // public function __invoke(int $id): JsonResponse
    // {
    //     try {
    //         $task = Task::findOrFail($id);
    //         $task->delete();

    //         logActivity(
    //             "Задача удалена",
    //             "Задача '{$task->title}' удалена пользователем " . auth()->user()->first_name . " " . auth()->user()->last_name
    //         );

    //         return static::toResponse(
    //             message: "$id - id li Task O'shirildi",
    //         );
    //     } catch (ModelNotFoundException $ex) {
    //         throw new ApiResponseException('Task Not Found', 404);
    //     }
    // }
}
