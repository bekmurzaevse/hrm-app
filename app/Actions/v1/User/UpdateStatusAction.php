<?php

namespace App\Actions\v1\User;

use App\Dto\User\UpdateStatusDto;
use App\Exceptions\ApiResponseException;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateStatusAction
{
    use ResponseTrait;

    public function __invoke(int $id, UpdateStatusDto $dto): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            if ($user->status === $dto->status) {
                return static::toResponse(
                    message: "$id - id li userdin' statusi ALDINNAN $dto->status qa ten'!",
                    // data: new CandidateResource($candidate)
                );
            }
            $user->update(['status' => $dto->status]);

            return static::toResponse(
                message: "$id - id li userdin' statusi $dto->status qa jan'alandi",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('User Not Found', 404);
        }
    }
}
