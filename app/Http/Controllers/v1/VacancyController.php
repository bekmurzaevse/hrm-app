<?php

namespace App\Http\Controllers\v1;

use App\Actions\v1\Vacancy\DeleteAction;
use App\Actions\v1\Vacancy\File\DeleteFileAction;
use App\Actions\v1\Vacancy\File\DownloadAction;
use App\Actions\v1\Vacancy\UpdateAction;
use App\Actions\v1\Vacancy\CreateAction;
use App\Actions\v1\Vacancy\ShowAction;
use App\Actions\v1\Vacancy\File\UploadAction;
use App\Dto\Vacancy\File\UploadDto;
use App\Dto\Vacancy\CreateDto;
use App\Dto\Vacancy\UpdateDto;
use App\Http\Controllers\Controller;
use App\Actions\v1\Vacancy\IndexAction;
use App\Http\Requests\v1\Vacancy\CreateRequest;
use App\Http\Requests\v1\Vacancy\UpdateRequest;
use App\Http\Requests\v1\Vacancy\File\UploadRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VacancyController extends Controller
{
    /**
     * Summary of index
     * @param \App\Actions\v1\Vacancy\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of show
     * @param int $id
     * @param \App\Actions\v1\Vacancy\ShowAction $action
     * @return JsonResponse
     */
    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\v1\Vacancy\CreateRequest $request
     * @param \App\Actions\v1\Vacancy\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of update
     * @param int $id
     * @param \App\Http\Requests\v1\Vacancy\UpdateRequest $request
     * @param \App\Actions\v1\Vacancy\UpdateAction $action
     * @return JsonResponse
     */
    public function update(int $id, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($id, UpdateDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $id
     * @param \App\Actions\v1\Vacancy\DeleteAction $action
     * @return JsonResponse
     */
    public function delete(int $id, DeleteAction $action): JsonResponse
    {
        return $action($id);
    }

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
