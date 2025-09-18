<?php

namespace App\Http\Controllers\v1\Vacancy;

use App\Actions\v1\Vacancy\File\DeleteAction;
use App\Actions\v1\Vacancy\File\DownloadAction;
use App\Actions\v1\Vacancy\File\ShowAction;
use App\Actions\v1\Vacancy\File\UploadAction;
use App\Dto\v1\Vacancy\File\UploadDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Vacancy\File\UploadRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VacancyFileController extends Controller
{
    /**
     * Summary of downloadFile
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Vacancy\File\DownloadAction $action
     * @return BinaryFileResponse
     */
    public function downloadFile(int $id, int $fileId, DownloadAction $action): BinaryFileResponse
    {
        return $action($id, $fileId);
    }

    /**
     * Summary of showFile
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Vacancy\File\ShowAction $action
     * @return Response
     */
    public function showFile(int $id, int $fileId, ShowAction $action): Response
    {
        return $action($id, $fileId);
    }

    /**
     * Summary of uploadFile
     * @param int $id
     * @param \App\Http\Requests\v1\Vacancy\File\UploadRequest $request
     * @param \App\Actions\v1\Vacancy\File\UploadAction $action
     * @return JsonResponse
     */
    public function uploadFile(int $id, UploadRequest $request, UploadAction $action): JsonResponse
    {
        return $action($id, UploadDto::from($request));
    }

    /**
     * Summary of deleteFile
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Vacancy\File\DeleteAction $action
     * @return JsonResponse
     */
    public function deleteFile(int $id, int $fileId, DeleteAction $action): JsonResponse
    {
        return $action($id, $fileId);
    }
}
