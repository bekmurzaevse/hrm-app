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
                'title' => $vacancy->title,
                'client_name' => $vacancy->client->name ?? '',
                'department' => $vacancy->department,
                'district_title' => $vacancy->district->title ?? '',
                'type_employment' => $vacancy->type_employment->value ?? '',
                'work_schedule' => $vacancy->work_schedule->value ?? '',
                'work_experience' => $vacancy->work_experience->value ?? '',
                'education' => $vacancy->education->value ?? '',
                'status' => $vacancy->status->value ?? '',
                'position_count' => $vacancy->position_count,
                'created_by_name' => $vacancy->createdBy->first_name ?? '',
                'salary_from' => $vacancy->salary_from,
                'salary_to' => $vacancy->salary_to,
                'currency' => $vacancy->currency->value ?? '',
                'period' => $vacancy->period->value ?? '',
                'bonus' => $vacancy->bonus->value ?? '',
                'probation' => $vacancy->probation,
                'probation_salary' => $vacancy->probation_salary,
                'description' => $vacancy->description,
                'requirements' => $vacancy->requirements,
                'responsibilities' => $vacancy->responsibilities,
                'work_conditions' => $vacancy->work_conditions,
                'benefits' => $vacancy->benefits,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Client Name',
            'Department',
            'District Title',
            'Type Employment',
            'Work Schedule',
            'Work Experience',
            'Education',
            'Status',
            'Position Count',
            'Created By Name',
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
            'Created_at',
            'Updated_at',
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
            'B' => 5, 
            'C' => 25,  
            'D' => 20,  
            'E' => 15,  
            'F' => 15,  
            'G' => 10, 
            'H' => 15,  
            'I' => 20,  
        ];
    }

}