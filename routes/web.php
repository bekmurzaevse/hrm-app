<?php

use Illuminate\Support\Facades\Route;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return Excel::download(new UsersExport, 'users.xlsx');
});
