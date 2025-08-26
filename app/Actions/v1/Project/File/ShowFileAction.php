<?php

namespace App\Actions\v1\Project\File;

use App\Exceptions\ApiResponseException;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ShowFileAction
{
    public function __invoke(int $id, int $fileId): Response
    {
        try {
            $file = Project::findOrFail($id)
                ->files()
                ->findOrFail($fileId);

            if (!Storage::disk('public')->exists($file->path)) {
                throw new ApiResponseException('File Not Found', 404);
            }

            $mime = Storage::disk('public')->mimeType($file->path);
            $content = Storage::disk('public')->get($file->path);

            return response($content, 200)
                ->header('Content-Type', $mime)
                ->header('Content-Disposition', 'inline; filename="' . $file->name . '"');
        } catch (ModelNotFoundException $e) {
            $model = class_basename($e->getModel());
            throw new ApiResponseException("{$model} Not Found", 404);
        }
    }
}
