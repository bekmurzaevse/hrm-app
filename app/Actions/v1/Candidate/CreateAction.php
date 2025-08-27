<?php

namespace App\Actions\v1\Candidate;

use App\Dto\v1\Candidate\CreateDto;
use App\Helpers\FileUploadHelper;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Candidate\CreateDto $dto
     * @return JsonResponse
     */
    public function __invoke(CreateDto $dto): JsonResponse
    {
        $data = [
            'first_name' => $dto->firstName,
            'last_name' => $dto->lastName,
            'patronymic' => $dto->patronymic,
            'birth_date' => $dto->birthDate,
            'gender' => $dto->gender,
            'citizenship' => $dto->citizenship,
            'country_residence' => $dto->countryResidence,
            'region_id' => $dto->regionId,
            'family_status' => $dto->familyStatus,
            'family_info' => $dto->familyInfo,
            'status' => $dto->status,
            'workplace' => $dto->workplace,
            'position' => $dto->position,
            // 'city' => $dto->city,
            'address' => $dto->address,
            'desired_salary' => $dto->desiredSalary,
            'source' => $dto->source,
            'experience' => $dto->experience,
            'short_summary' => $dto->shortSummary,
            'achievments' => $dto->achievments,
            'comment' => $dto->comment,
            'description' => $dto->description,
            'user_id' => $dto->userId,
        ];

        $candidate = Candidate::create($data);

        if ($dto->photo) {
            $photo = $dto->photo;
            $data = FileUploadHelper::file($photo, "candidatesPhotos/{$candidate->id}");

            $candidate->photo()->create([
                'name' => $photo->getClientOriginalName(),
                'path' => $data['path'],
                'type' => "photo",
                'size' => $photo->getSize(),
            ]);
        }

        logActivity(
            "Кандидат создан!",
            "Кандидат {$dto->firstName} {$dto->lastName} {$dto->patronymic} был добавлен в систему."
        );

        return static::toResponse(
            message: 'Candidate created'
        );
    }
}
