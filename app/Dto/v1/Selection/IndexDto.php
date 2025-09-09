<?php

namespace App\Dto\v1\Selection;

use App\Http\Requests\v1\Selection\IndexRequest;

readonly class IndexDto
{
    public function __construct(
        public ?string $search,
        public ?int $perPage,
        public ?int $page,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Selection\IndexRequest $request
     * @return IndexDto
     */
    public static function from(IndexRequest $request): self
    {
        return new self(
            search: $request->input('search', null),
            perPage: $request->input('perpage', 10),
            page: $request->input('page', 1),
        );
    }
}
