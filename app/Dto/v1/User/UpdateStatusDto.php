<?php

namespace App\Dto\v1\User;

use App\Http\Requests\v1\User\UpdateStatusRequest;

readonly class UpdateStatusDto
{
    public function __construct(
        public string $status,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\User\UpdateStatusRequest $request
     * @return UpdateStatusDto
     */
    public static function from(UpdateStatusRequest $request): self
    {
        return new self(
            status: $request->status,
        );
    }
}
