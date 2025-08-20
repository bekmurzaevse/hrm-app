<?php

namespace App\Actions\v1\Candidate;

use App\Exceptions\ApiResponseException;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $candidate = Candidate::findOrFail($id);
            $candidate->files()->delete();

            Storage::disk('public')->deleteDirectory("candidates/$candidate->id");

            $candidateName = "{$candidate->first_name} {$candidate->last_name} {$candidate->patronymic}";

            $candidate->delete();

            logActivity(
                "Кандидат удалён!",
                "Кандидат {$candidateName} (ID {$id}) был удалён из системы."
            );

            return static::toResponse(
                message: "$id - id li candidate o'shirildi",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Candidate Not Found', 404);
        }
    }
}
