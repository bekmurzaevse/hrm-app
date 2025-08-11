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
            'status' => $dto->status,
            'workplace' => $dto->workplace,
            'position' => $dto->position,
            'city' => $dto->city,
            'address' => $dto->address,
            'salary' => $dto->salary,
            'desired_salary' => $dto->desiredSalary,
            'source' => $dto->source,
            'experience' => $dto->experience,
            'description' => $dto->description,
            'user_id' => $dto->userId,
        ];

        $candidate = Candidate::create($data);

        if ($dto->files){
            $uploadedFiles = FileUploadHelper::files($dto->files, "candidates/{$candidate->id}");

            array_map(function ($file) use ($candidate) {
                $candidate->files()->create($file);
            }, $uploadedFiles);
        }

        return static::toResponse(
            message: 'Candidate created'
        );
    }
}
