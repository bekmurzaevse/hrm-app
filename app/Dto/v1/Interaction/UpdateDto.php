<?php

namespace App\Dto\v1\Interaction;

use App\Http\Requests\v1\Interaction\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public string $value,
        public int $typeId,
        public int $candidateId,
        public int $userId,
        public ?string $description,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Interaction\UpdateRequest $request
     * @return UpdateDto
     */
    public static function from(UpdateRequest $request): self
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
