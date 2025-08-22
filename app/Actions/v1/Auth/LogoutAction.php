<?php

namespace App\Actions\v1\Auth;

use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class LogoutAction
{
    use ResponseTrait;

    public function __invoke(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();
        auth()->user()->tokens()->where('name', 'refresh token')->delete();

        return static::toResponse(
            message: 'User logged out successfully'
        );
    }
}