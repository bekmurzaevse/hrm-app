<?php

namespace App\Actions\v1\Interaction;

use App\Dto\v1\Interaction\CreateDto;
use App\Models\Interaction;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Interaction\CreateDto $dto
     * @return JsonResponse
     */
    public function __invoke(CreateDto $dto): JsonResponse
    {
        $data = [
            'value' => $dto->value,
            'type_id' => $dto->typeId,
            'candidate_id' => $dto->candidateId,
            'user_id' => auth()->user()->id,
            'description' => $dto->description,
        ];

        $interaction = Interaction::create($data);

        logActivity(
            "Создано взаимодействие",
            "Взаимодействие '{$interaction->value}' создано для кандидата {$interaction->candidate->first_name} {$interaction->candidate->last_name} пользователем {$interaction->user->first_name} {$interaction->user->last_name}"
        );

        return static::toResponse(
            message: "Interaction created"
        );
    }
}
