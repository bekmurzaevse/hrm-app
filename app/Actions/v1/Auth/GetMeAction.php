<?php

namespace App\Actions\v1\Auth;

use App\Http\Resources\v1\Auth\GetMeResource;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class GetMeAction
{
    use ResponseTrait;

    public function __invoke(): JsonResponse
    {
        return static::toResponse(
            message: 'User received successfully',
            data: new GetMeResource(auth()->user())
        );
    }
}