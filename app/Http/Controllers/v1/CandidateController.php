<?php

namespace App\Http\Controllers\V1;

use App\Actions\v1\Candidate\DeleteAction;
use App\Dto\Candidate\CreateDto;
use App\Actions\v1\Candidate\CreateAction;
use App\Actions\v1\Candidate\DownloadAction;
use App\Actions\v1\Candidate\IndexAction;
use App\Actions\v1\Candidate\ShowAction;
use App\Actions\v1\Candidate\UpdateAction;
use App\Actions\v1\Candidate\UploadAction;
use App\Dto\Candidate\UpdateDto;
use App\Dto\Candidate\UploadDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Candidate\CreateRequest;
use App\Http\Requests\v1\Candidate\UpdateRequest;
use App\Http\Requests\v1\Candidate\UploadRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CandidateController extends Controller
{

    /**
     * Summary of index
     * @param \App\Actions\v1\Candidate\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of show
     * @param int $id
     * @param \App\Actions\v1\Candidate\ShowAction $action
     * @return JsonResponse
     */
    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\v1\Candidate\CreateRequest $request
     * @param \App\Actions\v1\Candidate\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of update
     * @param int $id
     * @param \App\Http\Requests\v1\Candidate\UpdateRequest $request
     * @param \App\Actions\v1\Candidate\UpdateAction $action
     * @return JsonResponse
     */
    public function update(int $id, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($id, UpdateDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $id
     * @param \App\Actions\v1\Candidate\DeleteAction $action
     * @return JsonResponse
     */
    public function delete(int $id, DeleteAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of upload
     * @param int $id
     * @param \App\Http\Requests\v1\Candidate\UploadRequest $request
     * @param \App\Actions\v1\Candidate\UploadAction $action
     * @return JsonResponse
     */
    public function upload(int $id, UploadRequest $request, UploadAction $action): JsonResponse
    {
        return $action($id, UploadDto::from($request));
    }

    public function download(int $id, int $fileId, DownloadAction $action): StreamedResponse
    {
        return $action($id, $fileId);
    }

}
