<?php

namespace App\Actions\v1\Interaction;

use App\Exceptions\ApiResponseException;
use App\Models\Interaction;
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
            $interaction = Interaction::findOrFail($id);

            $value = $interaction->value;
            $candidate = $interaction->candidate;
            $user = $interaction->user;

            $interaction->delete();

            logActivity(
                "Удалено взаимодействие",
                "Взаимодействие '{$value}' {$interaction->type->title} для кандидата {$candidate->first_name} {$candidate->last_name} удалено пользователем $user->first_name $user->last_name"
            );

            return static::toResponse(
                message: "$id - id li Interaction o'shirildi",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Interaction Not Found', 404);
        }
    }
}
