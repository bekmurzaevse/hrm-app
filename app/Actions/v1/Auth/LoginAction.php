<?php

namespace App\Actions\v1\Auth;

use App\Dto\v1\Auth\LoginDto;
use App\Enums\TokenAbilityEnum;
use App\Exceptions\ApiResponseException;
use App\Http\Resources\v1\Auth\GetMeResource;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    use ResponseTrait;

    public function __invoke(LoginDto $dto): JsonResponse
    {
        try {
            $user = User::where('email', $dto->email)->firstOrFail();

            if (!Hash::check($dto->password, $user->password)) {
                throw new ApiResponseException('Email or password is incorrect', 401);
            }

            auth()->login($user);

            $accessTokenExpiration = now()->addMinutes(config('sanctum.at_expiration'));
            $refreshTokenExpiration = now()->addMinutes(config('sanctum.rt_expiration'));

            $accessToken = auth()->user()->createToken(
                name: 'access token',
                abilities: [TokenAbilityEnum::ACCESS_TOKEN->value],
                expiresAt: $accessTokenExpiration
            );

            $refreshToken = auth()->user()->createToken(
                name: 'refresh token',
                abilities: [TokenAbilityEnum::ISSUE_ACCESS_TOKEN->value],
                expiresAt: $refreshTokenExpiration
            );

            return static::toResponse(
                message: "User logged in successfully",
                data: [
                    'access_token' => $accessToken->plainTextToken,
                    'refresh_token' => $refreshToken->plainTextToken,
                    'at_expired_at' => $accessTokenExpiration->format('Y-m-d H:i:s'),
                    'rf_expired_at' => $refreshTokenExpiration->format('Y-m-d H:i:s'),
                    'user' =>  new GetMeResource(auth()->user())
                ]
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Email or password is incorrect', 401);
        }
    }
}
