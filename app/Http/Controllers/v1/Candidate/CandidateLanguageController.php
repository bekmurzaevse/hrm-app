<?php

namespace App\Http\Controllers\v1\Candidate;

use App\Actions\v1\Candidate\Language\AddLanguageAction;
use App\Actions\v1\Candidate\Language\DeleteLanguageAction;
use App\Actions\v1\Candidate\Language\UpdateLanguageAction;
use App\Dto\v1\Candidate\Language\AddLanguageDto;
use App\Dto\v1\Candidate\Language\UpdateLanguageDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Candidate\Language\AddLanguageRequest;
use App\Http\Requests\v1\Candidate\Language\UpdateLanguageRequest;
use Illuminate\Http\JsonResponse;

class CandidateLanguageController extends Controller
{
    /**
     * Summary of languageCreate
     * @param int $id
     * @param \App\Http\Requests\v1\Candidate\Language\AddLanguageRequest $request
     * @param \App\Actions\v1\Candidate\Language\AddLanguageAction $action
     * @return JsonResponse
     */
    public function languageCreate(int $id, AddLanguageRequest $request, AddLanguageAction $action): JsonResponse
    {
        return $action($id, AddLanguageDto::from($request));
    }

    /**
     * Summary of languageUpdate
     * @param int $id
     * @param int $langId
     * @param \App\Http\Requests\v1\Candidate\Language\UpdateLanguageRequest $request
     * @param \App\Actions\v1\Candidate\Language\UpdateLanguageAction $action
     * @return JsonResponse
     */
    public function languageUpdate(int $id, int $langId, UpdateLanguageRequest $request, UpdateLanguageAction $action): JsonResponse
    {
        return $action($id, $langId, UpdateLanguageDto::from($request));
    }

    /**
     * Summary of languageDelete
     * @param int $id
     * @param \App\Actions\v1\Candidate\Language\DeleteLanguageAction $action
     * @return JsonResponse
     */
    public function languageDelete(int $id, DeleteLanguageAction $action): JsonResponse
    {
        return $action($id);
    }
}
