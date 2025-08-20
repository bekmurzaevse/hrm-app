<?php

namespace App\Actions\v1\User;

use App\Dto\User\CreateDto;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\User\CreateDto $dto
     * @return JsonResponse
     */
    public function __invoke(CreateDto $dto): JsonResponse
    {
        $data = [
            'first_name' => $dto->firstName,
            'last_name' => $dto->lastName,
            'patronymic' => $dto->patronymic,
            'birth_date' => $dto->birthDate,
            'address' => $dto->address,
            'position' => $dto->position,
            'phone' => $dto->phone,
            'email' => $dto->email,
            'status' => $dto->status,
            'password' => $dto->password,
        ];

        $user = User::create($data);

        logActivity(
            "Пользователь создан!",
            "Создан новый пользователь: {$user->first_name} {$user->last_name} (ID: {$user->id}) в файле " . __FILE__
        );

        return static::toResponse(
            message: 'User created'
        );
    }
}
