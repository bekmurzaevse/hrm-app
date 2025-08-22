<?php

namespace App\Actions\v1\Client;

use App\Exceptions\ApiResponseException;
use App\Models\Client;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class DownloadAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param int $fileId
     * @throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $id, int $fileId)
    {
        try {
            $file = Client::findOrFail($id)
                ->files()
                ->where('id', $fileId)
                ->firstOrFail();

            $filePath = $file->path;

            if (!Storage::disk('public')->exists($filePath)) {
                throw new ApiResponseException('File Not Found', 404);
            }

            return Storage::disk('public')->download($filePath, $file->name);
        } catch (ModelNotFoundException $ex) {
            $model = class_basename($ex->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
