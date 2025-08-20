<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\UpdateLanguageDto;
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
     * @param \App\Dto\Candidate\UpdateLanguageDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
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
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Language Not Found', 404);
        }
    }
}
