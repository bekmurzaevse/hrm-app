<?php

namespace App\Actions\v1\Client;

use App\Dto\v1\Client\CreateDto;
use App\Models\Client;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Client\CreateDto $dto
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
            'user_id' => auth()->user()->id,
            'INN' => $dto->INN,
            'employee_count' => $dto->employeeCount,
            'source' => $dto->source,
            'activity' => $dto->activity,
            'description' => $dto->description,
            'notes' => $dto->notes,
        ];

        $client = Client::create($data);

        logActivity(
            "Client Created!",
            "Добавлен новый клиент: {$client->name}",
        );

        return static::toResponse(
            message: "Client created"
        );
    }
}
