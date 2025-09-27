<?php

namespace App\Actions\v1\Vacancy;

use App\Exports\VacancyExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportIndexAction
{
    /**
     * Summary of __invoke
     */
    public function __invoke(): BinaryFileResponse
    {
        $fileName = 'vacancies_' . now()->format('Y_m_d_His') . '.xlsx';

        return Excel::download(new VacancyExport(), $fileName);
    }
}