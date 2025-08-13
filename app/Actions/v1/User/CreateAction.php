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
            'position' => $dto->position,
            'phone' => $dto->phone,
            'email' => $dto->email,
            'status' => $dto->status,
            'password' => $dto->password,
        ];

        User::create($data);

        return static::toResponse(
            message: 'User created'
        );
    }
}
