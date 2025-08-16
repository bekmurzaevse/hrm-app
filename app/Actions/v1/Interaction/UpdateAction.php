<?php

namespace App\Actions\v1\Interaction;

use App\Dto\Interaction\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Models\Interaction;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    public function __invoke(int $id, UpdateDto $dto): JsonResponse
    {
        try {
            $interaction = Interaction::findOrFail($id);
            $interaction->update([
                'value' => $dto->value,
                'type_id' => $dto->typeId,
                'candidate_id' => $dto->candidateId,
                'user_id' => $dto->userId,
                'description' => $dto->description,
            ]);

            return static::toResponse(
                message: "$id - id li Interaction jan'alandi",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Interaction Not Found', 404);
        }
    }
}
