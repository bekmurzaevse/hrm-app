<?php

namespace App\Http\Controllers\v1;

use App\Actions\v1\Type\CreateAction;
use App\Actions\v1\Type\DeleteAction;
use App\Actions\v1\Type\IndexAction;
use App\Actions\v1\Type\ShowAction;
use App\Actions\v1\Type\UpdateAction;
use App\Dto\Type\CreateDto;
use App\Dto\Type\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Type\CreateRequest;
use App\Http\Requests\v1\Type\UpdateRequest;
use Illuminate\Http\JsonResponse;

class TypeController extends Controller
{

    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    public function create(CreateRequest $request, CreateAction $action)
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
