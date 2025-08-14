<?php

namespace App\Actions\v1\Client;

use App\Dto\Client\CreateDto;
use App\Helpers\FileUploadHelper;
use App\Models\Client;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Client\CreateDto $dto
     * @return JsonResponse
     */
    public function __invoke(CreateDto $dto): JsonResponse
    {
        $data = [
            'name' => $dto->name,
            'status' => $dto->status,
            'leader' => $dto->leader,
            'contact_person' => $dto->contactPerson,
            'user_id' => $dto->userId,
            'INN' => $dto->INN,
            'KPP' => $dto->KPP,
            'employee_count' => $dto->employeeCount,
            'source' => $dto->source,
            'activity' => $dto->activity,
            'city' => $dto->city,
            'description' => $dto->description,
        ];

        $client = Client::create($data);

        if ($dto->files){
            $uploadedFiles = FileUploadHelper::files($dto->files, "clients/{$client->id}");

            array_map(function ($file) use ($client) {
                $client->files()->create($file);
            }, $uploadedFiles);
        }

        return static::toResponse(
            message: "Client created"
        );
    }
}
