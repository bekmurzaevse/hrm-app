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
        public int $regionId,
        public string $familyStatus,
        public ?string $familyInfo,
        public ?string $status,
        public ?string $workplace,
        public string $position,
        // public string $city,
        public string $address,
        public string $desiredSalary,
        public ?string $source,
        public ?float $experience,
        public ?string $shortSummary,
        public ?string $achievments,
        public ?string $comment,
        public ?string $description,
        public int $userId,
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
            regionId: $request->region_id,
            familyStatus: $request->family_status,
            familyInfo: $request->family_info,
            status: $request->status,
            workplace: $request->workplace,
            position: $request->position,
            // city: $request->city,
            address: $request->address,
            desiredSalary: $request->desired_salary,
            source: $request->source,
            experience: $request->experience,
            shortSummary: $request->short_summary,
            achievments: $request->achievments,
            comment: $request->comment,
            description: $request->description,
            userId: $request->user_id,
            photo: $request->file('photo'),
        );
    }
}
