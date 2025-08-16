<?php

namespace App\Dto\Vacancy;

use App\Http\Requests\v1\Vacancy\CreateRequest;
use Date;

readonly class CreateDto
{
    public function __construct(
        public string $title,
        public int $clientId,
        public ?string $department,
        public ?string $city,
        public string $typeEmployment,
        public string $workSchedule,
        public string $workExperience,
        public string $education,
        public string $status,
        public int $positionCount,
    ) {
    }


    public static function from(CreateRequest $request): self
    {
        return new self(
            title: $request->title,
            clientId: $request->client_id,
            department: $request->department,
            city: $request->city,
            typeEmployment: $request->type_employment,
            workSchedule: $request->work_schedule,
            workExperience: $request->work_experience,
            education: $request->education,
            status: $request->status,
            positionCount: $request->position_count,
        );
    }
}
