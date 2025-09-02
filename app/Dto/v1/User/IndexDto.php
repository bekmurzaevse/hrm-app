<?php

namespace App\Dto\v1\User;

use App\Http\Requests\v1\User\IndexRequest;

readonly class IndexDto
{
    public function __construct(
        public ?string $status,
        public ?string $search,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\User\IndexRequest $request
     * @return IndexDto
     */
    public static function from(IndexRequest $request): self
    {
        return new self(
            status: $request->status,
            search: $request->search,
        );
    }
}
