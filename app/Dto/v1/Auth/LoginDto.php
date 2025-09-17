<?php

namespace App\Dto\v1\Auth;

use App\Http\Requests\v1\Auth\LoginRequest;

readonly class LoginDto
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Auth\LoginRequest $request
     * @return LoginDto
     */
    public static function from(LoginRequest $request): self
    {
        return new self(
            email: $request->input('email'),
            password: $request->input('password')
        );
    }
}