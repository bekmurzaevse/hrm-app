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
        return Vacancy::all()->map(function ($vacancy) {
            return [
                'ID' => $vacancy->id,
                'Title' => $vacancy->title,
                'Client ID' => $vacancy->client_id,
                'Department' => $vacancy->department,
                'District ID' => $vacancy->district_id,
                'Type Employment' => $vacancy->type_employment?->value,
                'Work Schedule' => $vacancy->work_schedule?->value,
                'Work Experience' => $vacancy->work_experience?->value,
                'Education' => $vacancy->education?->value,
                'Status' => $vacancy->status?->value,
                'Position Count' => $vacancy->position_count,
                'Created By' => $vacancy->created_by,
                'Salary From' => $vacancy->salary_from,
                'Salary To' => $vacancy->salary_to,
                'Currency' => $vacancy->currency?->value,
                'Period' => $vacancy->period?->value,
                'Bonus' => $vacancy->bonus,
                'Probation' => $vacancy->probation,
                'Probation Salary' => $vacancy->probation_salary,
                'Description' => $vacancy->description,
                'Requirements' => $vacancy->requirements,
                'Responsibilities' => $vacancy->responsibilities,
                'Work Conditions' => $vacancy->work_conditions,
                'Benefits' => $vacancy->benefits,
                'Created At' => $vacancy->created_at?->format('Y-m-d H:i:s'),
                'Updated At' => $vacancy->updated_at?->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Client ID',
            'Department',
            'District ID',
            'Type Employment',
            'Work Schedule',
            'Work Experience',
            'Education',
            'Status',
            'Position Count',
            'Created By',
            'Salary From',
            'Salary To',
            'Currency',
            'Period',
            'Bonus',
            'Probation',
            'Probation Salary',
            'Description',
            'Requirements',
            'Responsibilities',
            'Work Conditions',
            'Benefits',
            'Created At',
            'Updated At',
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


    public function columnWidths(): array
    {
        return [
            'B' => 5,   // ID ustuni
            'C' => 25,  // Title
            'D' => 20,  // Department
            'E' => 15,  // Salary From
            'F' => 15,  // Salary To
            'G' => 10,  // Currency
            'H' => 15,  // Status
            'I' => 20,  // Created At
        ];
    }

}