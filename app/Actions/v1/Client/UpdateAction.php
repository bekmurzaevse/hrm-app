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

                'person_position' => $dto->personPosition,
                'person_phone' => $dto->personPhone,
                'person_email' => $dto->personEmail,

                'phone' => $dto->phone,
                'email' => $dto->email,
                'address' => $dto->address,

                'user_id' => $dto->userId,
                'INN' => $dto->INN,
                'employee_count' => $dto->employeeCount,
                'source' => $dto->source,
                'activity' => $dto->activity,
                'description' => $dto->description,
                'notes' => $dto->notes,
            ]);

            // if ($dto->files) {
            //     Storage::disk('public')->deleteDirectory("clients/$client->id");
            //     $client->files()->delete();

            //     $uploadedFiles = FileUploadHelper::files($dto->files, "clients/$client->id");

            //     array_map(function ($file) use ($client) {
            //         $client->files()->create($file);
            //     }, $uploadedFiles);
            // }

            logActivity("Client Updated!", "$client->name обновлено!");

            return static::toResponse(
                message: "$id - id li client jan'alandi",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Client Not Found', 404);
        }
    }
}
