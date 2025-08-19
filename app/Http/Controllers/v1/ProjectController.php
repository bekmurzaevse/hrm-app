<?php

namespace App\Http\Controllers\v1;

use App\Actions\v1\Project\CloseProjectAction;
use App\Actions\v1\Project\CompleteStageAction;
use App\Actions\v1\Project\CreateAction;
use App\Actions\v1\Project\CreateContractAction;
use App\Actions\v1\Project\CreateStageAction;
use App\Actions\v1\Project\DeleteStageAction;
use App\Actions\v1\Project\DownloadFileAction;
use App\Actions\v1\Project\IndexAction;
use App\Actions\v1\Project\SetRequireStageAction;
use App\Actions\v1\Project\ShowAction;
use App\Actions\v1\Project\ShowFileAction;
use App\Actions\v1\Project\UpdateAction;
use App\Actions\v1\Project\UpdatePerformerAction;
use App\Actions\v1\Project\UpdateStageAction;
use App\Actions\v1\Project\UploadFileAction;
use App\Actions\v1\Project\DeleteFileAction;
use App\Dto\Project\CloseProjectDto;
use App\Dto\Project\CompleteStageDto;
use App\Dto\Project\CreateContractDto;
use App\Dto\Project\CreateDto;
use App\Dto\Project\CreateStageDto;
use App\Dto\Project\UpdateDto;
use App\Dto\Project\UpdatePerformerDto;
use App\Dto\Project\UpdateStageDto;
use App\Dto\Project\UploadFileDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Project\CloseProjectRequest;
use App\Http\Requests\v1\Project\CompleteStageRequest;
use App\Http\Requests\v1\Project\CreateContractRequest;
use App\Http\Requests\v1\Project\CreateRequest;
use App\Http\Requests\v1\Project\CreateStageRequest;
use App\Http\Requests\v1\Project\UpdatePerformerRequest;
use App\Http\Requests\v1\Project\UpdateRequest;
use App\Http\Requests\v1\Project\UpdateStageRequest;
use App\Http\Requests\v1\Project\UploadFileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProjectController extends Controller
{
    /**
     * Summary of index
     * @param \App\Actions\v1\Project\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of show
     * @param int $id
     * @param \App\Actions\v1\Project\ShowAction $action
     * @return JsonResponse
     */
    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\v1\Project\CreateRequest $request
     * @param \App\Actions\v1\Project\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of createContract
     * @param \App\Http\Requests\v1\Project\CreateContractRequest $request
     * @param \App\Actions\v1\Project\CreateContractAction $action
     * @return JsonResponse
     */
    public function createContract(int $id, CreateContractRequest $request, CreateContractAction $action): JsonResponse
    {
        return $action($id, CreateContractDto::from($request));
    }

    public function updatePerformers(int $id, UpdatePerformerRequest $request, UpdatePerformerAction $action): JsonResponse
    {
        return $action($id, UpdatePerformerDto::from($request));
    }

    /**
     * Summary of update
     * @param int $id
     * @param \App\Http\Requests\v1\Project\UpdateRequest $request
     * @param \App\Actions\v1\Project\UpdateAction $action
     * @return JsonResponse
     */
    public function update(int $id, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($id, UpdateDto::from($request));
    }

    /**
     * Summary of closeProject
     * @param int $id
     * @param \App\Http\Requests\v1\Project\CloseProjectRequest $request
     * @param \App\Actions\v1\Project\CloseProjectAction $action
     * @return JsonResponse
     */
    public function closeProject(int $id, CloseProjectRequest $request, CloseProjectAction $action): JsonResponse
    {
        return $action($id, CloseProjectDto::from($request));
    }

    /**
     * Summary of downloadFile
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Project\DownloadFileAction $action
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
     * @param \App\Actions\v1\Project\ShowFileAction $action
     * @return Response
     */
    public function showFile(int $id, int $fileId, ShowFileAction $action): Response
    {
        return $action($id, $fileId);
    }

    /**
     * Summary of uploadFile
     * @param int $id
     * @param \App\Http\Requests\v1\Project\UploadFileRequest $request
     * @param \App\Actions\v1\Project\UploadFileAction $action
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
     * @param \App\Actions\v1\Project\DeleteFileAction $action
     * @return JsonResponse
     */
    public function deleteFile(int $id, int $fileId, DeleteFileAction $action): JsonResponse
    {
        return $action($id, $fileId);
    }

    /**
     * Summary of createStage
     * @param int $id
     * @param \App\Http\Requests\v1\Project\CreateStageRequest $request
     * @param \App\Actions\v1\Project\CreateStageAction $action
     * @return JsonResponse
     */
    public function createStage(int $id, CreateStageRequest $request, CreateStageAction $action): JsonResponse
    {
        return $action($id, CreateStageDto::from($request));
    }

    /**
     * Summary of updateStage
     * @param int $id
     * @param int $stageId
     * @param \App\Http\Requests\v1\Project\UpdateStageRequest $request
     * @param \App\Actions\v1\Project\UpdateStageAction $action
     * @return JsonResponse
     */
    public function updateStage(int $stageId, UpdateStageRequest $request, UpdateStageAction $action): JsonResponse
    {
        return $action($stageId, UpdateStageDto::from($request));
    }

    /**
     * Summary of setRequireStage
     * @param int $id
     * @param int $stageId
     * @param \App\Actions\v1\Project\SetRequireStageAction $action
     * @return JsonResponse
     */
    public function setRequireStage(int $stageId, SetRequireStageAction $action): JsonResponse
    {
        return $action($stageId);
    }

    /**
     * Summary of completeStage
     * @param int $stageId
     * @param \App\Http\Requests\v1\Project\CompleteStageRequest $request
     * @param \App\Actions\v1\Project\CompleteStageAction $action
     * @return JsonResponse
     */
    public function completeStage(int $stageId, CompleteStageRequest $request, CompleteStageAction $action): JsonResponse
    {
        return $action($stageId, CompleteStageDto::from($request));
    }

    /**
     * Summary of deleteStage
     * @param int $id
     * @param int $stageId
     * @param \App\Actions\v1\Project\DeleteStageAction $action
     * @return JsonResponse
     */
    public function deleteStage(int $stageId, DeleteStageAction $action): JsonResponse
    {
        return $action($stageId);
    }
}
