<?php

namespace App\Actions\v1\Selection;

use App\Exports\SelectionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportIndexAction
{
    /**
     * Summary of __invoke
     */
    public function __invoke(): BinaryFileResponse
    {
        $filename = 'Мои_подборки_' . now()->format('Y_m_d_H_i_s') . '.xlsx';

        return Excel::download(new SelectionsExport(), $filename);
    }
}