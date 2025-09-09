<?php

namespace App\Dto\v1\Selection;

use App\Http\Requests\v1\Selection\DeleteManyRequest;

readonly class DeleteManyDto
{
    public function __construct(
        public array $ids,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Selection\DeleteManyRequest $request
     * @return IndexDto
     */
    public static function from(DeleteManyRequest $request): self
    {
        return new self(
            ids: $request->input('ids'),
        );
    }
}
