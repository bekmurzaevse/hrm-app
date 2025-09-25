<?php

namespace App\Http\Controllers\v1\Task;

use App\Actions\v1\Task\Accept\AcceptAction;
use App\Actions\v1\Task\Complete\CompleteAction;
use App\Actions\v1\Task\CreateAction;
use App\Actions\v1\Task\Executor\AddExecutorAction;
use App\Actions\v1\Task\Executor\RemoveExecutorAction;
use App\Actions\v1\Task\Executor\UpdateExecutorAction;
use App\Actions\v1\Task\History\GetHistoryAction;
use App\Actions\v1\Task\IndexAction;
use App\Actions\v1\Task\Reject\RejectAction;
use App\Actions\v1\Task\ShowAction;
use App\Actions\v1\Task\History\LogChangeAction;
use App\Actions\v1\Task\Transfer\TransferAction;
use App\Actions\v1\Task\UpdateAction;
use App\Dto\v1\Task\Complete\CompleteDto;
use App\Dto\v1\Task\CreateDto;
use App\Dto\v1\Task\Executor\AddDto;
use App\Dto\v1\Task\Executor\RemoveExecutorDto;
use App\Dto\v1\Task\Executor\UpdateExecutorDto;
use App\Dto\v1\Task\History\LogChangeDto;
use App\Dto\v1\Task\Reject\RejectDto;
use App\Dto\v1\Task\Transfer\TransferDto;
use App\Dto\v1\Task\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Task\Complete\CompleteRequest;
use App\Http\Requests\v1\Task\CreateRequest;
use App\Http\Requests\v1\Task\Executor\AddRequest;
use App\Http\Requests\v1\Task\Executor\RemoveExecutorRequest;
use App\Http\Requests\v1\Task\Executor\UpdateExecutorRequest;
use App\Http\Requests\v1\Task\History\LogChangeRequest;
use App\Http\Requests\v1\Task\Reject\RejectRequest;
use App\Http\Requests\v1\Task\Transfer\TransferRequest;
use App\Http\Requests\v1\Task\UpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{

    /**
     * Summary of index
     * @param \App\Actions\v1\Task\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of show
     * @param int $id
     * @param \App\Actions\v1\Task\ShowAction $action
     * @return JsonResponse
     */
    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\v1\Task\CreateRequest $request
     * @param \App\Actions\v1\Task\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of update
     * @param int $id
     * @param \App\Http\Requests\v1\Task\UpdateRequest $request
     * @param \App\Actions\v1\Task\UpdateAction $action
     * @return JsonResponse
     */
    public function update(int $id, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($id, UpdateDto::from($request));
    }

    // /**
    //  * Summary of destroy
    //  * @param int $id
    //  * @param \App\Actions\v1\Task\DeleteAction $action
    //  * @return JsonResponse
    //  */
    // // public function destroy(int $id, DeleteAction $action): JsonResponse
    // // {
    // //     return $action($id);
    // // }

    /**
     * Summary of complete
     * @param \App\Http\Requests\v1\Task\Complete\CompleteRequest $request
     * @param \App\Actions\v1\Task\Complete\CompleteAction $action
     * @return JsonResponse
     */
    public function complete(CompleteRequest $request, CompleteAction $action): JsonResponse
    {
        return $action(CompleteDto::from($request));
    }

    /**
     * Summary of addExecutor
     * @param \App\Http\Requests\v1\Task\Executor\AddRequest $request
     * @param \App\Actions\v1\Task\Executor\AddExecutorAction $action
     * @return JsonResponse
     */
    public function addExecutor(AddRequest $request, AddExecutorAction $action): JsonResponse
    {
        return $action(AddDto::from($request));
    }

    /**
     * Summary of updateExecutor
     * @param \App\Http\Requests\v1\Task\Executor\UpdateExecutorRequest $request
     * @param \App\Actions\v1\Task\Executor\UpdateExecutorAction $action
     * @return JsonResponse
     */
    public function updateExecutor(UpdateExecutorRequest $request, UpdateExecutorAction $action): JsonResponse
    {
        return $action(UpdateExecutorDto::from($request));
    }

    /**
     * Summary of removeExecutor
     * @param \App\Http\Requests\v1\Task\Executor\RemoveExecutorRequest $request
     * @param \App\Actions\v1\Task\Executor\RemoveExecutorAction $action
     * @return JsonResponse
     */
    public function removeExecutor(RemoveExecutorRequest $request, RemoveExecutorAction $action): JsonResponse
    {
        return $action(RemoveExecutorDto::from($request));
    }

    /**
     * Summary of transfer
     * @param \App\Http\Requests\v1\Task\Transfer\TransferRequest $request
     * @param \App\Actions\v1\Task\Transfer\TransferAction $action
     * @return JsonResponse
     */
    public function transfer(TransferRequest $request, TransferAction $action): JsonResponse
    {
        return $action(TransferDto::from($request));
    }

    /**
     * Summary of history
     * @param int $id
     * @param \App\Actions\v1\Task\History\GetHistoryAction $action
     * @return AnonymousResourceCollection
     */
    public function history(int $id, GetHistoryAction $action): AnonymousResourceCollection
    {
        return $action($id);
    }

    /**
     * Summary of reject
     * @param \App\Http\Requests\v1\Task\Reject\RejectRequest $request
     * @param \App\Actions\v1\Task\Reject\RejectAction $action
     * @return JsonResponse
     */
    public function reject(RejectRequest $request, RejectAction $action): JsonResponse
    {
        return $action(RejectDto::from($request));
    }

    public function accept(int $id, AcceptAction $action): JsonResponse
    {
        return $action($id);
    }

}