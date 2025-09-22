<?php

namespace App\Actions\v1\User;

use App\Exceptions\ApiResponseException;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();

            logActivity(
                "Пользователь удален!",
                "Удален пользователь: {$user->first_name} {$user->last_name} (ID: {$user->id}) в файле " . __FILE__
            );

            return static::toResponse(
                message: "$id - id li user o'shirildi",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('User Not Found', 404);
        }
    }
}
