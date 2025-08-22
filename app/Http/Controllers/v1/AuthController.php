<?php

namespace App\Http\Controllers\v1;

use App\Actions\v1\Auth\LoginAction;
use App\Actions\v1\Auth\LogoutAction;
use App\Actions\v1\Auth\RefreshTokenAction;
use App\Dto\v1\Auth\LoginDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Summary of login
     * @param \App\Http\Requests\v1\Auth\LoginRequest $request
     * @param \App\Actions\v1\Auth\LoginAction $action
     * @return JsonResponse
     */
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        return $action(LoginDto::from($request));
    }

    /**
     * Summary of refreshToken
     * @param \App\Actions\v1\Auth\RefreshTokenAction $action
     * @return JsonResponse
     */
    public function refreshToken(RefreshTokenAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of logout
     * @param \App\Actions\v1\Auth\LogoutAction $action
     * @return JsonResponse
     */
    public function logout(LogoutAction $action): JsonResponse
    {
        return $action();
    }
}