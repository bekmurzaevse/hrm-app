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

     public function __invoke(int $id): JsonResponse
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

            return static::toResponse(
                message: "$id - id li Task O'shirildi",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task Not Found', 404);
        }
    }
}
