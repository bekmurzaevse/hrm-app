<?php

namespace App\Actions\v1\Candidate\Language;

use App\Dto\v1\Candidate\Language\UpdateLanguageDto;
use App\Exceptions\ApiResponseException;
use App\Models\Language;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateLanguageAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param int $langId
     * @param \App\Dto\v1\Candidate\Language\UpdateLanguageDto $dto
     * @return JsonResponse
     *@throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $id, int $langId, UpdateLanguageDto $dto): JsonResponse
    {
        try {
            $language = Language::findOrFail($langId);

            $oldData = $language->only([
                'title', 'degree', 'candidate_id', 'description'
            ]);

            $language->update([
                'title'        => $dto->title,
                'degree'       => $dto->degree,
                'candidate_id' => $id,
                'description'  => $dto->description,
            ]);

            logActivity(
                "Языковое знание обновлено!",
                "У кандидата {$language->candidate->first_name} {$language->candidate->last_name} был обновлён язык (ID {$langId}).
                 Старые данные: " . json_encode($oldData, JSON_UNESCAPED_UNICODE) .
                 " | Новые данные: " . json_encode([
                    'title'        => $dto->title,
                    'degree'       => $dto->degree,
                    'candidate_id' => $id,
                    'description'  => $dto->description,
                 ], JSON_UNESCAPED_UNICODE)
            );

            return static::toResponse(
                message: "$id - id li candidate tin' tilleri jan'alandi!",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Language Not Found', 404);
        }
    }
}
