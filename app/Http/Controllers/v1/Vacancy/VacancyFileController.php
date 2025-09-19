<?php

namespace App\Http\Controllers\v1\Vacancy;

use App\Actions\v1\Vacancy\File\DeleteAction;
use App\Actions\v1\Vacancy\File\DownloadAction;
use App\Actions\v1\Vacancy\File\UploadAction;
use App\Dto\v1\Vacancy\File\UploadDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Vacancy\File\UploadRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VacancyFileController extends Controller
{
    /**
     * Summary of download
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Vacancy\File\DownloadAction $action
     * @return BinaryFileResponse
     */
    public function download(int $id, int $fileId, DownloadAction $action): BinaryFileResponse
    {
        return $action($id, $fileId);
    }

    /**
     * Summary of upload
     * @param int $id
     * @param \App\Http\Requests\v1\Vacancy\File\UploadRequest $request
     * @param \App\Actions\v1\Vacancy\File\UploadAction $action
     * @return JsonResponse
     */
    public function upload(int $id, UploadRequest $request, UploadAction $action): JsonResponse
    {
        return $action($id, UploadDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Vacancy\File\DeleteAction $action
     * @return JsonResponse
     */
    public function delete(int $id, int $fileId, DeleteAction $action): JsonResponse
    {
        return $action($id, $fileId);
    }
}
