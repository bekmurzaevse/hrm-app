<?php

namespace App\Exports;

use App\Models\Vacancy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VacancyExport implements FromCollection, WithHeadings, ShouldAutoSize, WithCustomStartCell
{
    public function collection()
    {
        return Vacancy::with(['client', 'district', 'createdBy'])->get()->map(function ($vacancy) {
            return [
                'title' => $vacancy->title, // Job title
                'client_name' => $vacancy->client->name ?? '', // Client name
                'district_title' => $vacancy->district->title ?? '', // District title
                'status' => $vacancy->status->value ?? '', // Status
                'position_count' => $vacancy->position_count, // Number of positions
                'created_by_name' => $vacancy->createdBy->first_name ?? '',
                'salary_from' => $vacancy->salary_from,
                'salary_to' => $vacancy->salary_to,
                'created_at' => $vacancy->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Title',  
            'Client Name', 
            'District Title', 
            'Status', 
            'Position Count', 
            'Created By Name',
            'Salary From',
            'Salary To',
            'Created_at',
        ];
    }

    public function startCell(): string
    {
        return 'B2';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            2 => ['font' => ['bold' => true]],

            'B2:I1000' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];
    }

}