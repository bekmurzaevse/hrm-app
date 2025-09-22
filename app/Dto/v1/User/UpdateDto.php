<?php

namespace App\Dto\v1\User;

use App\Http\Requests\v1\User\UpdateRequest;

readonly class UpdateDto
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
     * @param \App\Http\Requests\v1\User\UpdateRequest $request
     * @return UpdateDto
     */
    public static function from(UpdateRequest $request): self
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
