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

    public function __invoke(int $id, int $langId, UpdateLanguageDto $dto): JsonResponse
    {
        try {
            Language::findOrFail($langId)->update([
                'title' => $dto->title,
                'degree' => $dto->degree,
                'candidate_id' => $id,
                'description' => $dto->description,
            ]);

            return static::toResponse(
                message: "$id - id li candidate tin' tilleri jan'alandi!",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Language Not Found', 404);
        }
    }
}
