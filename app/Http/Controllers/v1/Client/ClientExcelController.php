<?php

namespace App\Http\Controllers\v1\Client;

use App\Actions\v1\Client\Excel\ExportAction;
use App\Http\Controllers\Controller;

class ClientExcelController extends Controller
{
    /**
     * Summary of export
     * @param \App\Actions\v1\Client\Excel\ExportAction $action
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(ExportAction $action)
    {
        return $action();
    }
}
