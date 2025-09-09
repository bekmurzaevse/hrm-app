<?php

namespace App\Http\Controllers\v1\Dashboard;

use App\Actions\v1\Dashboard\IndexAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(IndexAction $action)
    {
        return $action();
    }
}
