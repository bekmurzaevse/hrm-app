<?php

namespace App\Actions\v1\User;

use App\Dto\User\UpdateStatusDto;
use App\Exceptions\ApiResponseException;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateStatusAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\User\UpdateStatusDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, UpdateStatusDto $dto): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            if ($user->status === $dto->status) {
                logActivity(
                    "Статус без изменений",
                    "Пользователь {$user->first_name} {$user->last_name} (ID: {$user->id}) уже имеет статус {$dto->status}. Файл: " . __FILE__
                );

                return static::toResponse(
                    message: "$id - id li userdin' statusi ALDINNAN $dto->status qa ten'!",
                );
            }
            $oldStatus = $user->status;
            $user->update(['status' => $dto->status]);

            logActivity(
                "Статус пользователя обновлен",
                "У пользователя {$user->first_name} {$user->last_name} (ID: {$user->id}) статус изменен: с {$oldStatus} на {$dto->status}. Файл: " . __FILE__
            );

            return static::toResponse(
                message: "$id - id li userdin' statusi $dto->status qa jan'alandi",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('User Not Found', 404);
        }
    }
}
