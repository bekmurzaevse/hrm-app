<?php

namespace App\Http\Controllers\v1\Vacancy;

use App\Actions\v1\Vacancy\File\DeleteFileAction;
use App\Actions\v1\Vacancy\File\DownloadFileAction;
use App\Actions\v1\Vacancy\File\ShowFileAction;
use App\Actions\v1\Vacancy\File\UploadFileAction;
use App\Dto\v1\Vacancy\File\UploadFileDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Vacancy\File\UploadFileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VacancyFileController extends Controller
{
    /**
     * Summary of downloadFile
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Vacancy\File\DownloadFileAction $action
     * @return BinaryFileResponse
     */
    public function downloadFile(int $id, int $fileId, DownloadFileAction $action): BinaryFileResponse
    {
        return $action($id, $fileId);
    }

    /**
     * Summary of showFile
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Vacancy\File\ShowFileAction $action
     * @return Response
     */
    public function showFile(int $id, int $fileId, ShowFileAction $action): Response
    {
        return $action($id, $fileId);
    }

    /**
     * Summary of uploadFile
     * @param int $id
     * @param \App\Http\Requests\v1\Vacancy\File\UploadFileRequest $request
     * @param \App\Actions\v1\Vacancy\File\UploadFileAction $action
     * @return JsonResponse
     */
    public function uploadFile(int $id, UploadFileRequest $request, UploadFileAction $action): JsonResponse
    {
        return $action($id, UploadFileDto::from($request));
    }

    /**
     * Summary of deleteFile
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Vacancy\File\DeleteFileAction $action
     * @return JsonResponse
     */
    public function deleteFile(int $id, int $fileId, DeleteFileAction $action): JsonResponse
    {
        return $action($id, $fileId);
    }
}
