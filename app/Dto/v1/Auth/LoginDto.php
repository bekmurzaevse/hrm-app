<?php

namespace App\Dto\v1\Auth;

use App\Http\Requests\v1\Auth\LoginRequest;

readonly class LoginDto
{
    /**
     * Summary of __construct
     * @param string $email
     * @param string $password
     */
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
            email: $request->get('email'),
            password: $request->get('password')
        );
    }
}