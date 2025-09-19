<?php

namespace App\Http\Controllers\v1\Project;

use App\Actions\v1\Project\File\DeleteFileAction;
use App\Actions\v1\Project\File\DownloadFileAction;
use App\Actions\v1\Project\File\UploadFileAction;
use App\Dto\v1\Project\File\UploadDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Project\File\UploadFileRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProjectFileController extends Controller
{
    /**
     * Summary of downlo
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Project\File\DownloadFileAction $action
     * @return BinaryFileResponse
     */
    public function download(int $id, int $fileId, DownloadFileAction $action): BinaryFileResponse
    {
        return $action($id, $fileId);
    }

    /**
     * Summary of upload
     * @param int $id
     * @param \App\Http\Requests\v1\Project\File\UploadFileRequest $request
     * @param \App\Actions\v1\Project\File\UploadFileAction $action
     * @return JsonResponse
     */
    public function upload(int $id, UploadFileRequest $request, UploadFileAction $action): JsonResponse
    {
        return $action($id, UploadDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Project\File\DeleteFileAction $action
     * @return JsonResponse
     */
    public function delete(int $id, int $fileId, DeleteFileAction $action): JsonResponse
    {
        return $action($id, $fileId);
    }
}
