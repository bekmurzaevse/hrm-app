<?php

namespace App\Http\Controllers\v1;

use App\Actions\v1\Vacancy\CreateSkillAction;
use App\Actions\v1\Vacancy\DeleteAction;
use App\Actions\v1\Vacancy\DeleteSkillAction;
use App\Actions\v1\Vacancy\DownloadFileAction;
use App\Actions\v1\Vacancy\DeleteFileAction;
use App\Actions\v1\Vacancy\UpdateAction;
use App\Actions\v1\Vacancy\CreateAction;
use App\Actions\v1\Vacancy\ShowAction;
use App\Actions\v1\Vacancy\UpdateSkillAction;
use App\Actions\v1\Vacancy\UploadFileAction;
use App\Dto\Vacancy\CreateDto;
use App\Dto\Vacancy\CreateSkillDto;
use App\Dto\Vacancy\UpdateDto;
use App\Dto\Vacancy\UpdateSkillDto;
use App\Dto\Vacancy\UploadFileDto;
use App\Http\Controllers\Controller;
use App\Actions\v1\Vacancy\IndexAction;
use App\Http\Requests\v1\Vacancy\CreateRequest;
use App\Http\Requests\v1\Vacancy\CreateSkillRequest;
use App\Http\Requests\v1\Vacancy\UpdateRequest;
use App\Http\Requests\v1\Vacancy\UpdateSkillRequest;
use App\Http\Requests\v1\Vacancy\UploadFileRequest;
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
     * Summary of downloadFile
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Vacancy\DownloadFileAction $action
     * @return BinaryFileResponse
     */
    public function downloadFile(int $id, int $fileId, DownloadFileAction $action): BinaryFileResponse
    {
        return $action($id, $fileId);
    }

    /**
     * Summary of uploadFile
     * @param int $id
     * @param \App\Http\Requests\v1\Vacancy\UploadFileRequest $request
     * @param \App\Actions\v1\Vacancy\UploadFileAction $action
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
     * @param \App\Actions\v1\Vacancy\DeleteFileAction $action
     * @return JsonResponse
     */
    public function deleteFile(int $id, int $fileId, DeleteFileAction $action): JsonResponse
    {
        return $action($id, $fileId);
    }

    /**
     * Summary of createSkills
     * @param int $id
     * @param \App\Http\Requests\v1\Vacancy\CreateSkillRequest $request
     * @param \App\Actions\v1\Vacancy\CreateSkillAction $action
     * @return JsonResponse
     */
    public function createSkills(int $id, CreateSkillRequest $request, CreateSkillAction $action): JsonResponse
    {
        return $action($id, CreateSkillDto::from($request));
    }

    /**
     * Summary of updateSkill
     * @param int $id
     * @param int $skillId
     * @param \App\Http\Requests\v1\Vacancy\UpdateSkillRequest $request
     * @param \App\Actions\v1\Vacancy\UpdateSkillAction $action
     * @return JsonResponse
     */
    public function updateSkill(int $id, int $skillId, UpdateSkillRequest $request, UpdateSkillAction $action): JsonResponse
    {
        return $action($id, $skillId, UpdateSkillDto::from($request));
    }

    /**
     * Summary of deleteSkill
     * @param int $id
     * @param int $skillId
     * @param \App\Actions\v1\Vacancy\DeleteSkillAction $action
     * @return JsonResponse
     */
    public function deleteSkill(int $id, int $skillId, DeleteSkillAction $action): JsonResponse
    {
        return $action($id, $skillId);
    }
}
