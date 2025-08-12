<?php

namespace App\Actions\v1\Client;

use App\Dto\Client\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Helpers\FileUploadHelper;
use App\Models\Client;
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
     * @param \App\Dto\Client\UpdateDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, UpdateDto $dto): JsonResponse
    {
        try {
            $client = Client::findOrFail($id);
            $client->update([
                'name' => $dto->name,
                'status' => $dto->status,
                'leader' => $dto->leader,
                'contact_person' => $dto->contactPerson,
                'user_id' => $dto->userId,
                'INN' => $dto->INN,
                'KPP' => $dto->KPP,
                'employee_count' => $dto->employeeCount,
                'source' => $dto->source,
                'city' => $dto->city,
                'activity' => $dto->activity,
                'description' => $dto->description,
            ]);

            if ($dto->files) {
                Storage::disk('public')->deleteDirectory("clients/$client->id");
                $client->files()->delete();

                $uploadedFiles = FileUploadHelper::files($dto->files, "clients/$client->id");

                array_map(function ($file) use ($client) {
                    $client->files()->create($file);
                }, $uploadedFiles);
            }

            return static::toResponse(
                message: "$id - id li client jan'alandi",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Client Not Found', 404);
        }
    }
}
