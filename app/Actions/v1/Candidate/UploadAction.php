<?php

namespace App\Actions\v1\Candidate;

use App\Dto\Candidate\UploadDto;
use App\Helpers\FileUploadHelper;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

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

        $createdFiles = [];

        foreach ($uploadedFiles as $file) {
            $newFile = $candidate->files()->create([
                'name' => $file['name'],
                'path' => $file['path'],
                'type' => null,
                'size' => $file['size'],
            ]);
            $createdFiles[] = $newFile->only(['id', 'name', 'path', 'size']);
        }

        logActivity(
            "Файлы загружены!",
            "К кандидату $candidate->first_name $candidate->last_name были прикреплены новые файлы: " .
            json_encode($createdFiles, JSON_UNESCAPED_UNICODE)
        );

        return static::toResponse(
            message: 'Uploaded files to candidate ' . $candidate->id
        );
    }
}
