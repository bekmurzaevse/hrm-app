<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\CreateDto;
use App\Helpers\FileUploadHelper;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Candidate\CreateDto $dto
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
            'region' => $dto->region,
            'family_status' => $dto->familyStatus,
            'family_info' => $dto->familyInfo,

            'status' => $dto->status,
            'workplace' => $dto->workplace,
            'position' => $dto->position,
            'city' => $dto->city,
            'address' => $dto->address,
            // 'salary' => $dto->salary,
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

        // if ($dto->files){
        //     $uploadedFiles = FileUploadHelper::files($dto->files, "candidates/{$candidate->id}");

        //     array_map(function ($file) use ($candidate) {
        //         $candidate->files()->create($file);
        //     }, $uploadedFiles);
        // }

        // if ($dto->skills){
        //     array_map(function ($skill) use ($candidate) {
        //         $candidate->skills()->create([
        //             'title' => $skill,
        //             'type' => 'skill',
        //         ]);
        //     }, $dto->skills);
        // }

        // if ($dto->languages){
        //     foreach ($dto->languages as $lan){
        //         $candidate->skills()->create([
        //             'title' => $lan,
        //             // 'type' => 'language',
        //         ]);
        //     }
        // }

        return static::toResponse(
            message: 'Candidate created'
        );
    }
}
