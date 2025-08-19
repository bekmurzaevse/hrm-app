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

            'person_position' => $dto->personPosition,
            'person_phone' => $dto->personPhone,
            'person_email' => $dto->personEmail,

            'phone' => $dto->phone,
            'email' => $dto->email,
            'address' => $dto->address,

            'user_id' => $dto->userId,
            'INN' => $dto->INN,
            // 'KPP' => $dto->KPP,
            'employee_count' => $dto->employeeCount,
            'source' => $dto->source,
            'activity' => $dto->activity,
            // 'city' => $dto->city,
            'description' => $dto->description,
            'notes' => $dto->notes,
        ];

        $client = Client::create($data);

        return static::toResponse(
            message: "Client created"
        );
    }
}
