<?php

namespace App\Exports;

use App\Models\Vacancy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VacancyExport implements FromCollection, WithHeadings, ShouldAutoSize, WithCustomStartCell, WithStyles
{
    public function collection()
    {
        $vacancies = Vacancy::with(['client', 'district', 'createdBy'])->get();

        return $vacancies->values()->map(function ($vacancy, $index) {
            return [
                'No' => $index + 1,
                'Title' => $vacancy->title,
                'Client Name' => $vacancy->client->name ?? '',
                'District Title' => $vacancy->district->title ?? '',
                'Status' => $vacancy->status->value ?? '',
                'Position Count' => $vacancy->position_count,
                'Created By Name' => $vacancy->createdBy->first_name ?? '',
                'Salary From' => $vacancy->salary_from,
                'Salary To' => $vacancy->salary_to,
                'Created At' => $vacancy->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            '№',
            'Название',
            'Клиент',
            'Район',
            'Статус',
            'Количество позиций',
            'Создано пользователем',
            'Зарплата от',
            'Зарплата до',
            'Дата создания',
        ];
    }

    public function startCell(): string
    {
        return 'B3';
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        $sheet->mergeCells('B2:K2');
        $sheet->setCellValue('B2', 'Вакансии');
        $sheet->getStyle('B2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->getStyle('B3:K3')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFEFEFEF'],
            ],
        ]);

        foreach (['B', 'D', 'E', 'F', 'G', 'H', 'K'] as $col) {
            $sheet->getStyle("{$col}3:{$col}{$highestRow}")
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        $sheet->getStyle("B2:K{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        return [];
    }
}