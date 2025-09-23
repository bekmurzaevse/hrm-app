<?php

namespace App\Actions\v1\Client\Excel;

use App\Exports\ClientsExport;
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
        return Excel::download(new ClientsExport, 'clients.xlsx');
    }
}
