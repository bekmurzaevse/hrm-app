<?php

namespace App\Dto\v1\Dashboard;

use App\Http\Requests\v1\Dashboard\IndexRequest;

readonly class IndexDto
{
    public function __construct(
        public ?string $projectSearch,
        public ?string $projectStatus,
        public ?string $projectStart,
        public ?string $projectEnd,
        public ?int $perPage,
    ) {
    }

    public static function from(IndexRequest $request): self
    {
        return new self(
            projectSearch: $request->project_search,
            projectStatus: $request->project_status,
            projectStart: $request->project_start,
            projectEnd: $request->project_end,
            perPage: $request->per_page,
        );
    }
}
