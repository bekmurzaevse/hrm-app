<?php

namespace App\Dto\v1\Selection\StatusValue;

use App\Http\Requests\v1\Selection\StatusValue\StoreRequest;

readonly class StoreDto
{
    public function __construct(
        public int $selectionItemId,
        public int $selectionStatusId,
        public string $value,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Selection\StatusValue\StoreRequest $request
     * @return StoreDTo
     */
    public static function from(StoreRequest $request): self
    {
        return new self(
            selectionItemId: $request->input('selection_item_id'),
            selectionStatusId: $request->input('selection_status_id'),
            value: $request->input('value')
        );
    }
}
