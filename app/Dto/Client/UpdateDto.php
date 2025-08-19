<?php

namespace App\Dto\Client;

use App\Http\Requests\v1\Client\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public string $name,
        public ?string $status,
        public string $leader,
        public string $contactPerson,
        public string $personPosition,
        public string $personPhone,
        public ?string $personEmail,
        public string $phone,
        public ?string $email,
        public string $address,
        public int $userId,
        public string $INN,
        public ?string $employeeCount,
        public string $source,
        public ?string $activity,
        public ?string $description,
        public ?string $notes,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Client\UpdateRequest $request
     * @return UpdateDto
     */
    public static function from(UpdateRequest $request): self
    {
        return new self(
            name: $request->get('name'),
            status: $request->get('status'),
            leader: $request->get('leader'),
            contactPerson: $request->get('contact_person'),
            personPosition: $request->get('person_position'),
            personPhone: $request->get('person_phone'),
            personEmail: $request->get('person_email'),
            phone: $request->get('phone'),
            email: $request->get('email'),
            address: $request->get('address'),
            userId: $request->get('user_id'),
            INN: $request->get('INN'),
            employeeCount: $request->get('employee_count'),
            source: $request->get('source'),
            activity: $request->get('activity'),
            description: $request->get('description'),
            notes: $request->get('notes'),
        );
    }
}
