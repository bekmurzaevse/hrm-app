<?php

namespace App\Http\Controllers\v1\Candidate;

use App\Actions\v1\Candidate\Excel\ExportAction;
use App\Http\Controllers\Controller;

class CandidateExcelController extends Controller
{
    /**
     * Summary of export
     * @param \App\Actions\v1\Candidate\Excel\ExportAction $action
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(ExportAction $action)
    {
        return $action();
    }
}
