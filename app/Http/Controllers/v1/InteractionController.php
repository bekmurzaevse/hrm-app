<?php

namespace App\Http\Controllers\v1;

use App\Actions\v1\Interaction\CreateAction;
use App\Actions\v1\Interaction\DeleteAction;
use App\Actions\v1\Interaction\IndexAction;
use App\Actions\v1\Interaction\ShowAction;
use App\Actions\v1\Interaction\UpdateAction;
use App\Dto\Interaction\CreateDto;
use App\Dto\Interaction\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Interaction\CreateRequest;
use App\Http\Requests\v1\Interaction\UpdateRequest;
use Illuminate\Http\JsonResponse;

class InteractionController extends Controller
{


    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    public function update(int $id, UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action($id, UpdateDto::from($request));
    }

    public function delete(int $id, DeleteAction $action)
    {
        return $action($id);
    }
    


}
