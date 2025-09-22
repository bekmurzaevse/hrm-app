<?php

namespace App\Dto\v1\User;

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
            firstName: $request->input('first_name'),
            lastName: $request->input('last_name'),
            patronymic: $request->input('patronymic'),
            birthDate: $request->input('birth_date'),
            address: $request->input('address'),
            position: $request->input('position'),
            status: $request->input('status'),
            phone: $request->input('phone'),
            email: $request->input('email'),
            password: $request->input('password'),
        );
    }
}
