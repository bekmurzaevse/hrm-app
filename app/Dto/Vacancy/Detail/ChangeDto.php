<?php

namespace App\Dto\Vacancy\Detail;

use App\Http\Requests\v1\Vacancy\Detail\ChangeRequest;

readonly class ChangeDto
{
    public function __construct(
        public string $description,
        public string $requirements,
        public string $responsibilities,
        public string $workConditions,
        public string $benefits,
    ) {
    }


    public static function from(ChangeRequest $request): self
    {
        return new self(
            description: $request->description,
            requirements: $request->requirements,
            responsibilities: $request->responsibilities,
            workConditions: $request->work_conditions,
            benefits: $request->benefits,
        );
    }
}
