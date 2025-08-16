<?php

namespace App\Dto\Interaction;

use App\Http\Requests\v1\Interaction\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public string $value,
        public int $typeId,
        public int $candidateId,
        public int $userId,
        public ?string $description,
    ) {
    }

    public static function from(CreateRequest $request): self
    {
        return new self(
            value: $request->value,
            typeId: $request->type_id,
            candidateId: $request->candidate_id,
            userId: $request->user_id,
            description: $request->description,
        );
    }
}
