<?php

namespace App\Actions\v1\User;

use App\Dto\User\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    public function __invoke(int $id, UpdateDto $dto): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->update([
                'first_name' => $dto->firstName,
                'last_name' => $dto->lastName,
                'patronymic' => $dto->patronymic,
                'position' => $dto->position,
                'status' => $dto->status,
                'phone' => $dto->phone,
                'email' => $dto->email,
                'password' => $dto->password,
            ]);

            return static::toResponse(
                message: "$id - id li user jan'alandi",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('User Not Found', 404);
        }
    }
}
