<?php

namespace App\Http\Controllers\v1\Task;

use App\Actions\v1\Task\IndexAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    
}