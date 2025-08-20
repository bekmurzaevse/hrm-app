<?php

namespace App\Dto\User;

use App\Http\Requests\v1\User\UpdateStatusRequest;

readonly class UpdateStatusDto
{
    public function __construct(
        public string $status,
    ) {
    }

    public static function from(UpdateStatusRequest $request): self
    {
        return new self(
            status: $request->status,
        );
    }
}
