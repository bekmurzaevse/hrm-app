<?php

namespace App\Http\Controllers\v1\Candidate;

use App\Actions\v1\Candidate\CreateAction;
use App\Actions\v1\Candidate\DeleteAction;
use App\Actions\v1\Candidate\IndexAction;
use App\Actions\v1\Candidate\ShowAction;
use App\Actions\v1\Candidate\UpdateAction;
use App\Dto\v1\Candidate\CreateDto;
use App\Dto\v1\Candidate\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Candidate\CreateRequest;
use App\Http\Requests\v1\Candidate\IndexRequest;
use App\Http\Requests\v1\Candidate\UpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Summary of index
     * @param \App\Actions\v1\Candidate\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexAction $action, IndexRequest $request): JsonResponse
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
}
