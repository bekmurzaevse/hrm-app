<?php

namespace App\Actions\v1\Candidate;

use App\Dto\v1\Candidate\UpdateDto;
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
     * @param \App\Dto\v1\Candidate\UpdateDto $dto
     * @return JsonResponse
     *@throws \App\Exceptions\ApiResponseException
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
                'country_residence' => $dto->countryResidence,
                // 'region_id' => $dto->regionId,
                'family_status' => $dto->familyStatus,
                'family_info' => $dto->familyInfo,
                'status' => $dto->status,
                'workplace' => $dto->workplace,
                'position' => $dto->position,
                'district_id' => $dto->districtId,
                'address' => $dto->address,
                'desired_salary' => $dto->desiredSalary,
                'source' => $dto->source,
                'experience' => $dto->experience,
                'short_summary' => $dto->shortSummary,
                'achievments' => $dto->achievments,
                'comment' => $dto->comment,
                'description' => $dto->description,
                'user_id' => $dto->userId,
            ]);

            if ($dto->photo) {
                if (Storage::disk('public')->exists($candidate->photo->path)) {
                    Storage::disk('public')->delete($candidate->photo->path);
                }

                $data = FileUploadHelper::file($dto->photo, "candidatesPhotos/{$candidate->id}");

                $candidate->photo()->update([
                    'name' => $dto->photo->getClientOriginalName(),
                    'path' => $data['path'],
                    'type' => "photo",
                    'size' => $dto->photo->getSize(),
                ]);
            }

            logActivity(
                "Кандидат обновлён!",
                "Кандидат $candidate->first_name $candidate->last_name был успешно обновлён пользователем " . ((auth()->user()->first_name ?? '') . ' ' . (auth()->user()->last_name ?? ''))
            );

            return static::toResponse(
                message: "$id - id li candidate jan'alandi",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            $model = class_basename($ex->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
