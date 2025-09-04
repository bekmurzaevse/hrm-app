<?php

namespace App\Http\Controllers\v1;

use App\Actions\v1\Region\IndexAction;
use App\Dto\v1\Region\IndexDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Region\IndexRequest;
use Illuminate\Http\JsonResponse;

class RegionController extends Controller
{
    /**
     * Summary of index
     * @param \App\Actions\v1\Region\IndexAction $action
     * @param \App\Http\Requests\v1\Region\IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexAction $action, IndexRequest $request): JsonResponse
    {
        return $action(IndexDto::from($request));
    }
}
