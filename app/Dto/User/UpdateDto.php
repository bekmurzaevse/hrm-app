<?php

namespace App\Dto\User;

use App\Http\Requests\v1\User\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $patronymic,
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
            firstName: $request->first_name,
            lastName: $request->last_name,
            patronymic: $request->patronymic,
            position: $request->position,
            status: $request->status,
            phone: $request->phone,
            email: $request->email,
            password: $request->password,
        );
    }
}
