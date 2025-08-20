<?php

namespace App\Http\Controllers\v1;

use App\Actions\v1\Client\CreateAction;
use App\Actions\v1\Client\DeleteAction;
use App\Actions\v1\Client\DeleteFileAction;
use App\Actions\v1\Client\DownloadAction;
use App\Actions\v1\Client\IndexAction;
use App\Actions\v1\Client\ShowAction;
use App\Actions\v1\Client\UpdateAction;
use App\Actions\v1\Client\UploadAction;
use App\Dto\Client\CreateDto;
use App\Dto\Client\UpdateDto;
use App\Dto\Client\UploadDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Client\CreateRequest;
use App\Http\Requests\v1\Client\UpdateRequest;
use App\Http\Requests\v1\Client\UploadRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ClientController extends Controller
{

    /**
     * Summary of index
     * @param \App\Actions\v1\Client\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }


    /**
     * Summary of show
     * @param int $id
     * @param \App\Actions\v1\Client\ShowAction $action
     * @return JsonResponse
     */
    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\v1\Client\CreateRequest $request
     * @param \App\Actions\v1\Client\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of update
     * @param int $id
     * @param \App\Http\Requests\v1\Client\UpdateRequest $request
     * @param \App\Actions\v1\Client\UpdateAction $action
     * @return JsonResponse
     */
    public function update(int $id, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($id, UpdateDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $id
     * @param \App\Actions\v1\Client\DeleteAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id, DeleteAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of upload
     * @param int $id
     * @param \App\Http\Requests\v1\Client\UploadRequest $request
     * @param \App\Actions\v1\Client\UploadAction $action
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
     * @param \App\Actions\v1\Client\DownloadAction $action
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
     * @param \App\Actions\v1\Client\DeleteFileAction $action
     * @return JsonResponse
     */
    public function deleteFile(int $id, int $fileId, DeleteFileAction $action): JsonResponse
    {
        return $action($id, $fileId);
    }

}
