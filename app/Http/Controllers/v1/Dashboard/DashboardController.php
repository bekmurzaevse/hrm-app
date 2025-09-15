<?php

namespace App\Http\Controllers\v1\Dashboard;

use App\Actions\v1\Dashboard\IndexAction;
use App\Dto\v1\Dashboard\IndexDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Dashboard\IndexRequest;

class DashboardController extends Controller
{

    /**
     * Summary of index
     * @param \App\Actions\v1\Dashboard\IndexAction $action
     * @param \App\Http\Requests\v1\Dashboard\IndexRequest $request
     */
    public function index(IndexAction $action, IndexRequest $request)
    {
        return $action(IndexDto::from($request));
    }
}
