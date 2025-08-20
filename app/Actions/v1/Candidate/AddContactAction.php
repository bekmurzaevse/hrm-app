<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\AddContactDto;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class AddContactAction
{
    use ResponseTrait;

    public function __invoke(int $id, AddContactDto $dto): JsonResponse
    {
        $candidate = Candidate::findOrFail($id);
        $candidate->contacts()->create([
            'title' => $dto->title,
            'value' => $dto->value,
        ]);

        logActivity("Added contact to candidate!", "к $candidate->first_name $candidate->last_name $candidate->patronymic $dto->title=$dto->value  добавлен контакт!");

        return static::toResponse(
            message: 'Contact added!'
        );
    }
}
