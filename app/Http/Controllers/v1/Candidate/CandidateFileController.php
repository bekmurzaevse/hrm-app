<?php

namespace App\Http\Controllers\v1\Candidate;

use App\Actions\v1\Candidate\File\DeleteFileAction;
use App\Actions\v1\Candidate\File\DownloadAction;
use App\Actions\v1\Candidate\File\UploadAction;
use App\Dto\v1\Candidate\File\UploadDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Candidate\File\UploadRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CandidateFileController extends Controller
{
    /**
     * Summary of upload
     * @param int $id
     * @param \App\Http\Requests\v1\Candidate\File\UploadRequest $request
     * @param \App\Actions\v1\Candidate\File\UploadAction $action
     * @return JsonResponse
     */
    public function upload(int $id, UploadRequest $request, UploadAction $action): JsonResponse
    {
        return $action($id, UploadDto::from($request));
    }

    /**
     * Summary of download
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Candidate\File\DownloadAction $action
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(int $id, int $fileId, DownloadAction $action): StreamedResponse
    {
        return $action($id, $fileId);
    }

    /**
     * Summary of deleteFile
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Candidate\File\DeleteFileAction $action
     * @return JsonResponse
     */
    public function deleteFile(int $id, int $fileId, DeleteFileAction $action): JsonResponse
    {
        return $action($id, $fileId);
    }
}
