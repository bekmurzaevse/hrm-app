<?php

namespace App\Dto\Client;

use App\Http\Requests\v1\Client\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public string $name,
        public ?string $status,
        public string $leader,
        public string $contactPerson,
        public int $userId,
        public string $INN,
        public string $KPP,
        public string $employeeCount,
        public string $source,
        public ?string $activity,
        public string $city,
        public ?string $description,
        public ?array $files,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Client\CreateRequest $request
     * @return CreateDto
     */
    public static function from(CreateRequest $request): self
    {
        return new self(
            name: $request->get('name'),
            status: $request->get('status'),
            leader: $request->get('leader'),
            contactPerson: $request->get('contact_person'),
            userId: $request->get('user_id'),
            INN: $request->get('INN'),
            KPP: $request->get('KPP'),
            employeeCount: $request->get('employee_count'),
            source: $request->get('source'),
            activity: $request->get('activity'),
            city: $request->get('city'),
            description: $request->get('description'),
            files: $request->file('files'),
        );
    }
}
