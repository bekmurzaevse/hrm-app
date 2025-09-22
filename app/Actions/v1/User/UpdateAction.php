<?php

namespace App\Actions\v1\User;

use App\Dto\v1\User\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\v1\User\UpdateDto $dto
     * @return JsonResponse
     *@throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $id, UpdateDto $dto): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->update([
                'first_name' => $dto->firstName,
                'last_name' => $dto->lastName,
                'patronymic' => $dto->patronymic,
                'birth_date' => $dto->birthDate,
                'address' => $dto->address,
                'position' => $dto->position,
                'status' => $dto->status,
                'phone' => $dto->phone,
                'email' => $dto->email,
                'password' => $dto->password,
            ]);

            logActivity(
                "Пользователь обновлен!",
                "Обновлены данные пользователя: {$user->first_name} {$user->last_name} (ID: {$user->id}) в файле " . __FILE__
            );

            return static::toResponse(
                message: "$id - id li user jan'alandi",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('User Not Found', 404);
        }
    }
}
