<?php

namespace App\Actions\v1\Interaction;

use App\Dto\Interaction\CreateDto;
use App\Models\Interaction;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    public function __invoke(CreateDto $dto): JsonResponse
    {
        $data = [
            'value' => $dto->value,
            'type_id' => $dto->typeId,
            'candidate_id' => $dto->candidateId,
            'user_id' => $dto->userId,
            'description' => $dto->description,
        ];

        $interaction = Interaction::create($data);

        logActivity("Interaction Created!", "$interaction->value добавлен!");

        return static::toResponse(
            message: "Interaction created"
        );
    }
}
