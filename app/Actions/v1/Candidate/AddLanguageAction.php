<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\AddLanguageDto;
use App\Models\Language;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class AddLanguageAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\Candidate\AddLanguageDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, AddLanguageDto $dto): JsonResponse
    {
        $data = [
            'title' => $dto->title,
            'degree' => $dto->degree,
            'candidate_id' => $id,
            'description' => $dto->description,
        ];

        $language = Language::create($data);

        logActivity(
            "Язык добавлен!",
            "Кандидату с ID {$id} добавлен язык {$language->title} с уровнем {$language->degree}."
        );

        return static::toResponse(
            message: 'Language added!'
        );
    }
}
