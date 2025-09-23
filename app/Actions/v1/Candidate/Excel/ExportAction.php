<?php

namespace App\Actions\v1\Candidate\Excel;

use App\Exports\CandidateExport;
use App\Traits\ResponseTrait;
use Maatwebsite\Excel\Facades\Excel;

class ExportAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function __invoke()
    {
        return Excel::download(new CandidateExport, 'candidates.xlsx');
    }
}
