<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\UploadDto;
use App\Helpers\FileUploadHelper;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UploadAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\Candidate\UploadDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, UploadDto $dto): JsonResponse
    {
        $candidate = Candidate::findOrFail($id);

        $uploadedFiles = FileUploadHelper::files($dto->files, "candidates/{$candidate->id}");

        foreach ($uploadedFiles as $file) {
            $candidate->files()->create([
                'name' => $file['name'],
                'path' => $file['path'],
                'type' => null,
                'size' => $file['size'],
            ]);
        }

        return static::toResponse(
            message: 'Uploaded files to candidate ' . $candidate->id
        );
    }
}
