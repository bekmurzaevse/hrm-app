<?php

namespace App\Dto\User;

use App\Http\Requests\v1\User\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $patronymic,
        public string $birthDate,
        public string $address,
        public string $position,
        public string $status,
        public string $phone,
        public string $email,
        public string $password,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\User\CreateRequest $request
     * @return CreateDto
     */
    public static function from(CreateRequest $request): self
    {
        return new self(
            firstName: $request->first_name,
            lastName: $request->last_name,
            patronymic: $request->patronymic,
            birthDate: $request->birth_date,
            address: $request->address,
            position: $request->position,
            status: $request->status,
            phone: $request->phone,
            email: $request->email,
            password: $request->password,
        );
    }
}
