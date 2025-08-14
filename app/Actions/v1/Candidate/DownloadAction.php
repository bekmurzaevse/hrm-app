<?php

namespace App\Actions\v1\Candidate;

use App\Exceptions\ApiResponseException;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class DownloadAction
{
    use ResponseTrait;

    public function __invoke(int $id, int $fileId)
    {
        try {
            $file = Candidate::findOrFail($id)
                ->files()
                ->where('id', $fileId)
                ->firstOrFail();

            $filePath = $file->path;

            if (!Storage::disk('public')->exists($filePath)) {
                throw new ApiResponseException('File Not Found', 404);
            }

            return Storage::disk('public')->download($filePath, $file->name);
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('File Not Found', 404);
        }
    }
}
