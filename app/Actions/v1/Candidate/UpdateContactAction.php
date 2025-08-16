<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\UpdateContactDto;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class UpdateContactAction
{
    use ResponseTrait;

    public function __invoke(int $id, int $contactId, UpdateContactDto $dto): JsonResponse
    {
        Candidate::findOrFail($id)->contacts()->findOrFail($contactId)->update([
            'title' => $dto->title,
            'value' => $dto->value,
        ]);

        return static::toResponse(
            message: 'Contact updated!'
        );
    }
}
