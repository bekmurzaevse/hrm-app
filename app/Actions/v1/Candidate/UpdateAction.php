<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Helpers\FileUploadHelper;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class UpdateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\Candidate\UpdateDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, UpdateDto $dto): JsonResponse
    {
        try {
            $candidate = Candidate::findOrFail($id);
            $candidate->update([
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
                'experience' => $dto->experience ?? null,
                'description' => $dto->description ?? null,
                'user_id' => $dto->userId,
            ]);

            if ($dto->files) {
                Storage::disk('public')->deleteDirectory("candidates/$candidate->id");
                $candidate->files()->delete();

                $uploadedFiles = FileUploadHelper::files($dto->files, "candidates/$candidate->id");

                array_map(function ($file) use ($candidate) {
                    $candidate->files()->create($file);
                }, $uploadedFiles);
            }

            return static::toResponse(
                message: "$id - id li candidate jan'alandi",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Candidate Not Found', 404);
        }
    }
}
