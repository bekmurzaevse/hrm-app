<?php

namespace App\Http\Controllers\v1;

use App\Actions\v1\Client\CreateAction;
use App\Actions\v1\Client\IndexAction;
use App\Actions\v1\Client\ShowAction;
use App\Dto\Client\CreateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Client\CreateRequest;
use Illuminate\Http\JsonResponse;

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

    // TODO
    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    // /**
    //  * Summary of update
    //  * @param int $id
    //  * @param \App\Http\Requests\v1\Candidate\UpdateRequest $request
    //  * @param \App\Actions\v1\Candidate\UpdateAction $action
    //  * @return JsonResponse
    //  */
    // public function update(int $id, UpdateRequest $request, UpdateAction $action): JsonResponse
    // {
    //     return $action($id, UpdateDto::from($request));
    // }

    // /**
    //  * Summary of delete
    //  * @param int $id
    //  * @param \App\Actions\v1\Candidate\DeleteAction $action
    //  * @return JsonResponse
    //  */
    // public function delete(int $id, DeleteAction $action): JsonResponse
    // {
    //     return $action($id);
    // }

}
