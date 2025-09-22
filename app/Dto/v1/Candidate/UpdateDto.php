<?php

namespace App\Dto\v1\Candidate;

use App\Http\Requests\v1\Candidate\UpdateRequest;
use Illuminate\Http\UploadedFile;

readonly class UpdateDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $patronymic,
        public string $birthDate,
        public string $gender,
        public string $citizenship,
        public ?string $countryResidence,
        public string $familyStatus,
        public ?string $familyInfo,
        public ?string $status,
        public ?string $workplace,
        public ?string $position,
        public int $districtId,
        public string $address,
        public ?string $desiredSalary,
        public ?string $source,
        public ?string $shortSummary,
        public ?string $achievments,
        public ?string $comment,
        public ?string $description,
        public ?UploadedFile $photo,
    ) {}

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Candidate\UpdateRequest $request
     * @return UpdateDto
     */
    public static function from(UpdateRequest $request): self
    {
        return new self(
            firstName: $request->input('first_name'),
            lastName: $request->input('last_name'),
            patronymic: $request->input('patronymic'),
            birthDate: $request->input('birth_date'),
            gender: $request->input('gender'),
            citizenship: $request->input('citizenship'),
            countryResidence: $request->input('country_residence'),
            familyStatus: $request->input('family_status'),
            familyInfo: $request->input('family_info'),
            status: $request->input('status'),
            workplace: $request->input('workplace'),
            position: $request->input('position'),
            districtId: $request->input('district_id'),
            address: $request->input('address'),
            desiredSalary: $request->input('desired_salary'),
            source: $request->input('source'),
            shortSummary: $request->input('short_summary'),
            achievments: $request->input('achievments'),
            comment: $request->input('comment'),
            description: $request->input('description'),
            photo: $request->file('photo'),
        );
    }
}
