<?php

namespace App\Dto\Candidate;

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
        public string $region,
        public string $familyStatus,
        public ?string $familyInfo,
        public ?string $status,
        public ?string $workplace,
        public string $position,
        public string $city,
        public string $address,
        // public string $salary,
        public string $desiredSalary,
        public ?string $source,
        public ?string $experience,
        public ?string $description,
        public int $userId,
        // public ?array $files,
        // public ?array $skills,
        // public ?array $languages,
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
            firstName: $request->first_name,
            lastName: $request->last_name,
            patronymic: $request->patronymic,
            birthDate: $request->birth_date,
            gender: $request->gender,
            citizenship: $request->citizenship,
            countryResidence: $request->country_residence,
            region: $request->region,
            familyStatus: $request->family_status,
            familyInfo: $request->family_info,
            status: $request->status,
            workplace: $request->workplace,
            position: $request->position,
            city: $request->city,
            address: $request->address,
            // salary: $request->salary,
            desiredSalary: $request->desired_salary,
            source: $request->source,
            experience: $request->experience,
            description: $request->description,
            userId: $request->user_id,
            // skills: $request->skills,
            // languages: $request->langs,
            // files: $request->file('files'),
            photo: $request->file('photo'),
        );
    }
}
