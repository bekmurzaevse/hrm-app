<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientsExport implements FromCollection, WithCustomStartCell, WithEvents, WithStyles, WithHeadings
{
    public function collection()
    {
        return Client::with(['user'])->get()
            ->map(function ($item, $key) {
                return [
                    '№' => $key + 1,
                    'Наименование' => $item->name,
                    'Статус' => match ($item->status?->value) {
                        'Active'    => 'Активный',
                        'Potential' => 'Потенциальный',
                        'Inactive'  => 'Неактивный',
                        default     => 'Не указан',
                    },
                    'Руководитель' => $item->leader,
                    'Контактное лицо' => $item->contact_person,
                    'Позиция лица' => $item->person_position,
                    'Телефон лица' => $item->person_phone,
                    'Электронная почта лица' => $item->person_email,
                    'Телефон' => $item->phone,
                    'Электронная почта' => $item->email,
                    'Адрес' => $item->address,
                    'Создано' => $item->user->first_name . ' ' . $item->user->last_name,
                    'ИНН' => $item->INN,
                    'Численность сотрудников' => $item->employee_count?->value,
                    'Источник' => $item->source,
                    'Активность' => $item->activity,
                    'Описание' => $item->description,
                    'Заметки' => $item->notes,
                ];
            });
    }

    public function headings(): array
    {
        return [
            '№',
            'Наименование',
            'Статус',
            'Руководитель',
            'Контактное лицо',
            'Позиция лица',
            'Телефон лица',
            'Электронная почта лица',
            'Телефон',
            'Электронная почта',
            'Адрес',
            'Создано',
            'ИНН',
            'Численность сотрудников',
            'Источник',
            'Активность',
            'Описание',
            'Заметки',
        ];
    }

    /**
     * Summary of startCell
     * @return string
     */
    public function startCell(): string
    {
        return 'B2';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            2 => [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $sheet = $event->sheet;

                $sheet->mergeCells('C1:S1');
                $sheet->setCellValue('C1', 'Клиенты');

                $sheet->getStyle('C1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('C1')->getAlignment()->setHorizontal('center');
            },

            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->fromArray(
                    $this->collection()->toArray(),
                    null,
                    'B3',
                    true
                );

                $sheet->fromArray(
                    [$this->headings()],
                    null,
                    'B2'
                );

                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();
                $sheet->getStyle("B2:{$lastColumn}{$lastRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle("C3:C{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                foreach (range('B', $lastColumn) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                $sheet->getStyle("B3:{$lastColumn}{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
