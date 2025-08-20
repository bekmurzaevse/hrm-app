<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\AddContactDto;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class AddContactAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\Candidate\AddContactDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, AddContactDto $dto): JsonResponse
    {
        $candidate = Candidate::findOrFail($id);
        $contact = $candidate->contacts()->create([
            'title' => $dto->title,
            'value' => $dto->value,
        ]);

        logActivity(
            "Добавлен новый контакт кандидату",
            "Кандидату {$candidate->first_name} {$candidate->last_name} (ID: {$candidate->id}) добавлен контакт: {$contact->title} - {$contact->value}. Файл: " . __FILE__
        );

        return static::toResponse(
            message: 'Contact added!'
        );
    }
}
