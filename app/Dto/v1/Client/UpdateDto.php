<?php

namespace App\Dto\v1\Client;

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
            name: $request->input('name'),
            status: $request->input('status'),
            leader: $request->input('leader'),
            contactPerson: $request->input('contact_person'),
            personPosition: $request->input('person_position'),
            personPhone: $request->input('person_phone'),
            personEmail: $request->input('person_email'),
            phone: $request->input('phone'),
            email: $request->input('email'),
            address: $request->input('address'),
            INN: $request->input('INN'),
            employeeCount: $request->input('employee_count'),
            source: $request->input('source'),
            activity: $request->input('activity'),
            description: $request->input('description'),
            notes: $request->input('notes'),
        );
    }
}
