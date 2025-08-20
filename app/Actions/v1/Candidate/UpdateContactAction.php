<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\UpdateContactDto;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class UpdateContactAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param int $contactId
     * @param \App\Dto\Candidate\UpdateContactDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, int $contactId, UpdateContactDto $dto): JsonResponse
    {
        $candidate = Candidate::findOrFail($id);
        $contact   = $candidate->contacts()->findOrFail($contactId);

        $oldData = $contact->only(['title', 'value']);

        logActivity(
            "Контакт обновлён!",
            "У кандидата $candidate->first_name $candidate->last_name был обновлён контакт $contact->title $contact->value.
             Старые данные: " . json_encode($oldData, JSON_UNESCAPED_UNICODE) .
             " | Новые данные: " . json_encode([
                'title' => $dto->title,
                'value' => $dto->value,
             ], JSON_UNESCAPED_UNICODE)
        );

        return static::toResponse(
            message: 'Contact updated!'
        );
    }
}
