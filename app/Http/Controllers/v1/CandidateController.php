<?php

namespace App\Http\Controllers\v1;

use App\Actions\v1\Candidate\AddContactAction;
use App\Actions\v1\Candidate\AddEducationAction;
use App\Actions\v1\Candidate\AddExperienceAction;
use App\Actions\v1\Candidate\AddLanguageAction;
use App\Actions\v1\Candidate\AddSkillAction;
use App\Actions\v1\Candidate\DeleteAction;
use App\Actions\v1\Candidate\UpdateContactAction;
use App\Dto\Candidate\CreateDto;
use App\Actions\v1\Candidate\CreateAction;
use App\Actions\v1\Candidate\DeleteContactAction;
use App\Actions\v1\Candidate\DeleteEducationAction;
use App\Actions\v1\Candidate\DeleteExperienceAction;
use App\Actions\v1\Candidate\DeleteFileAction;
use App\Actions\v1\Candidate\DeleteLanguageAction;
use App\Actions\v1\Candidate\DeleteSkillAction;
use App\Actions\v1\Candidate\DownloadAction;
use App\Actions\v1\Candidate\IndexAction;
use App\Actions\v1\Candidate\ShowAction;
use App\Actions\v1\Candidate\UpdateAction;
use App\Actions\v1\Candidate\UpdateEducationAction;
use App\Actions\v1\Candidate\UpdateExperienceAction;
use App\Actions\v1\Candidate\UpdateLanguageAction;
use App\Actions\v1\Candidate\UpdateSkillAction;
use App\Actions\v1\Candidate\UploadAction;
use App\Dto\Candidate\AddContactDto;
use App\Dto\Candidate\AddEducationDto;
use App\Dto\Candidate\AddExperienceDto;
use App\Dto\Candidate\AddLanguageDto;
use App\Dto\Candidate\AddSkillDto;
use App\Dto\Candidate\UpdateContactDto;
use App\Dto\Candidate\UpdateDto;
use App\Dto\Candidate\UpdateEducationDto;
use App\Dto\Candidate\UpdateExperienceDto;
use App\Dto\Candidate\UpdateLanguageDto;
use App\Dto\Candidate\UpdateSkillDto;
use App\Dto\Candidate\UploadDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Candidate\AddContactRequest;
use App\Http\Requests\v1\Candidate\AddEducationRequest;
use App\Http\Requests\v1\Candidate\AddLanguageRequest;
use App\Http\Requests\v1\Candidate\AddSkillRequest;
use App\Http\Requests\v1\Candidate\AddWorkExperienceRequest;
use App\Http\Requests\v1\Candidate\CreateRequest;
use App\Http\Requests\v1\Candidate\UpdateContactRequest;
use App\Http\Requests\v1\Candidate\UpdateEducationRequest;
use App\Http\Requests\v1\Candidate\UpdateLanguageRequest;
use App\Http\Requests\v1\Candidate\UpdateRequest;
use App\Http\Requests\v1\Candidate\UpdateSkillRequest;
use App\Http\Requests\v1\Candidate\UpdateWorkExperienceRequest;
use App\Http\Requests\v1\Candidate\UploadRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CandidateController extends Controller
{

    /**
     * Summary of index
     * @param \App\Actions\v1\Candidate\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexAction $action, Request $request): JsonResponse
    {
        return $action($request);
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

    /**
     * Summary of download
     * @param int $id
     * @param int $fileId
     * @param \App\Actions\v1\Candidate\DownloadAction $action
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
     * @param \App\Actions\v1\Candidate\DeleteFileAction $action
     * @return JsonResponse
     */
    public function deleteFile(int $id, int $fileId, DeleteFileAction $action): JsonResponse
    {
        return $action($id, $fileId);
    }

    /**
     * Summary of experienceCreate
     * @param int $id
     * @param \App\Http\Requests\v1\Candidate\AddWorkExperienceRequest $request
     * @param \App\Actions\v1\Candidate\AddExperienceAction $action
     * @return JsonResponse
     */
    public function experienceCreate(int $id, AddWorkExperienceRequest $request, AddExperienceAction $action): JsonResponse
    {
        return $action($id, AddExperienceDto::from($request));
    }

    /**
     * Summary of experienceUpdate
     * @param int $id
     * @param int $workId
     * @param \App\Http\Requests\v1\Candidate\UpdateWorkExperienceRequest $request
     * @param \App\Actions\v1\Candidate\UpdateExperienceAction $action
     * @return JsonResponse
     */
    public function experienceUpdate(int $id, int $workId, UpdateWorkExperienceRequest $request, UpdateExperienceAction $action): JsonResponse
    {
        return $action($id, $workId, UpdateExperienceDto::from($request));
    }

    /**
     * Summary of experienceDelete
     * @param int $id
     * @param \App\Actions\v1\Candidate\DeleteExperienceAction $action
     * @return JsonResponse
     */
    public function experienceDelete(int $id, DeleteExperienceAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of languageCreate
     * @param int $id
     * @param \App\Http\Requests\v1\Candidate\AddLanguageRequest $request
     * @param \App\Actions\v1\Candidate\AddLanguageAction $action
     * @return JsonResponse
     */
    public function languageCreate(int $id, AddLanguageRequest $request, AddLanguageAction $action): JsonResponse
    {
        return $action($id, AddLanguageDto::from($request));
    }

    /**
     * Summary of skillCreate
     * @param int $id
     * @param \App\Http\Requests\v1\Candidate\AddSkillRequest $request
     * @param \App\Actions\v1\Candidate\AddSkillAction $action
     * @return JsonResponse
     */
    public function skillCreate(int $id, AddSkillRequest $request, AddSkillAction $action): JsonResponse
    {
        return $action($id, AddSkillDto::from($request));
    }

    /**
     * Summary of educationCreate
     * @param int $id
     * @param \App\Http\Requests\v1\Candidate\AddEducationRequest $request
     * @param \App\Actions\v1\Candidate\AddEducationAction $action
     * @return JsonResponse
     */
    public function educationCreate(int $id, AddEducationRequest $request, AddEducationAction $action): JsonResponse
    {
        return $action($id, AddEducationDto::from($request));
    }

    /**
     * Summary of educationUpdate
     * @param int $id
     * @param int $educationId
     * @param \App\Http\Requests\v1\Candidate\UpdateEducationRequest $request
     * @param \App\Actions\v1\Candidate\UpdateEducationAction $action
     * @return JsonResponse
     */
    public function educationUpdate(int $id, int $educationId, UpdateEducationRequest $request, UpdateEducationAction $action): JsonResponse
    {
        return $action($id, $educationId, UpdateEducationDto::from($request));
    }

    /**
     * Summary of educationDelete
     * @param int $id
     * @param \App\Actions\v1\Candidate\DeleteEducationAction $action
     * @return JsonResponse
     */
    public function educationDelete(int $id, DeleteEducationAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of contactCreate
     * @param int $id
     * @param \App\Http\Requests\v1\Candidate\AddContactRequest $request
     * @param \App\Actions\v1\Candidate\AddContactAction $action
     * @return JsonResponse
     */
    public function contactCreate(int $id, AddContactRequest $request, AddContactAction $action): JsonResponse
    {
        return $action($id, AddContactDto::from($request));
    }

    /**
     * Summary of languageUpdate
     * @param int $id
     * @param int $langId
     * @param \App\Http\Requests\v1\Candidate\UpdateLanguageRequest $request
     * @param \App\Actions\v1\Candidate\UpdateLanguageAction $action
     * @return JsonResponse
     */
    public function languageUpdate(int $id, int $langId, UpdateLanguageRequest $request, UpdateLanguageAction $action): JsonResponse
    {
        return $action($id, $langId, UpdateLanguageDto::from($request));
    }

    /**
     * Summary of languageDelete
     * @param int $id
     * @param \App\Actions\v1\Candidate\DeleteLanguageAction $action
     * @return JsonResponse
     */
    public function languageDelete(int $id, DeleteLanguageAction $action): JsonResponse
    {
        return $action($id);
    }

    public function skillUpdate(int $id, int $skillId, UpdateSkillRequest $request, UpdateSkillAction $action): JsonResponse
    {
        return $action($id, $skillId, UpdateSkillDto::from($request));
    }

    public function skillDelete(int $id, int $skillId, DeleteSkillAction $action): JsonResponse
    {
        return $action($id, $skillId);
    }

    public function contactUpdate(int $id, int $contactId, UpdateContactRequest $request, UpdateContactAction $action): JsonResponse
    {
        return $action($id, $contactId, UpdateContactDto::from($request));
    }

    public function contactUDelete(int $id, int $contactId, DeleteContactAction $action): JsonResponse
    {
        return $action($id, $contactId);
    }




}
