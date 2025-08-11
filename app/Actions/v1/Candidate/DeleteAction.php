<?php

namespace App\Actions\v1\Candidate;

use App\Exceptions\ApiResponseException;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

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
            // $photo = $candidate->photo;

            // if ($photo) {
            //     $filePath = $photo->path;

            //     if ($filePath && Storage::disk('public')->exists($filePath)) {
            //         Storage::disk('public')->delete($filePath);
            //     }

            //     $photo->delete();
            // }

            $candidate->delete();

            return static::toResponse(
                message: "$id - id li candidate o'shirildi",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Candidate Not Found', 404);
        }
    }
}
