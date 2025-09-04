<?php

namespace App\Dto\v1\Region;

use App\Http\Requests\v1\Region\IndexRequest;

readonly class IndexDto
{
    public function __construct(
        public ?int $regionId,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Region\IndexRequest $request
     * @return IndexDto
     */
    public static function from(IndexRequest $request): self
    {
        return new self(
            regionId: $request->region_id,
        );
    }
}
