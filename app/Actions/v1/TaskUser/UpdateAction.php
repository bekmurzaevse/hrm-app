<?php

namespace App\Actions\v1\TaskUser;

use App\Dto\v1\TaskUser\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Http\Resources\v1\TaskUser\TaskUserResource;
use App\Models\TaskUser;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateAction
{
    use ResponseTrait;

    public function __invoke(int $id, UpdateDto $dto)
    {
        try {
            $taskUser = TaskUser::with('user', 'task')->findOrFail($id);
            $data = [
                'task_id' => $dto->task_id ?? $taskUser->task_id,
                'user_id' => auth()->user()->id,
                'assigned_at' => $dto->assigned_at ?? $taskUser->assigned_at,
                'status' => $dto->status ?? $taskUser->status,
            ];

            $taskUser->update($data);

            logActivity(
                "Task User обновлен!",
                "Task User для задачи '{$taskUser->task->title}' (ID: {$taskUser->task->id}) был обновлен пользователем"
                //auth()->user()->first_name . " " . auth()->user()->last_name
            );

            return static::toResponse(
                message: "$id - id li task user jan'alandı",
                data: new TaskUserResource($taskUser)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Task User Not Found', 404);
        }
    }
}