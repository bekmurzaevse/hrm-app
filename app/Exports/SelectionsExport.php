<?php

namespace App\Exports;

use App\Models\Selection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SelectionsExport implements FromCollection, ShouldAutoSize, WithCustomStartCell, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $selections = Selection::with(['createdBy:id,first_name,last_name,patronymic', 'items'])
            ->withCount('items')
            ->where('created_by', auth()->id())->get();

        $result = $selections->map(function ($selection) {
            return [
                'title' => $selection->title,
                'created_at' => $selection->created_at->format('Y-m-d'),
                'updated_at' => $selection->updated_at->format('Y-m-d'),
                'candidates' => (string) $selection->items_count,
            ];
        });

        return collect($result);
    }

    /**
     * Summary of startCell
     * @return string
     */
    public function startCell(): string
    {
        return 'C3';
    }

    /**
     * Summary of registerEvents
     * @return (callable(AfterSheet ):void)[]
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // B2->F2 heading
                $event->sheet->setCellValue('B2', '№');
                $event->sheet->setCellValue('C2', 'Заголовок');
                $event->sheet->setCellValue('D2', 'Создано');
                $event->sheet->setCellValue('E2', 'Изменено');
                $event->sheet->setCellValue('F2', 'Кандидаты');

                // B1->E1
                $event->sheet->mergeCells('B1:F1');
                $event->sheet->setCellValue('B1', 'Мои подборки');

                // Formating B1
                $event->sheet->getStyle('B1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // B2:E2 bold, background color
                $event->sheet->getStyle('B2:F2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Get row count
                $rowCount = count($this->collection());

                // Last row
                $lastRow = $rowCount + 2;

                // B2->E{$lastRow}
                $range = "B2:F{$lastRow}";

                // Draw border and set color
                $event->sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(
                    Border::BORDER_THIN
                );

                // C2->E{$lastRow}
                $range = "D2:F{$lastRow}";

                // Set text alignment
                $event->sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // B3->B{$lastRow}
                for ($row = 3; $row <= $lastRow; $row++) {
                    $event->sheet->setCellValue("B{$row}", $row - 2);
                }

                // B3->B{$lastRow}
                $range = "B3:B{$lastRow}";

                // Set text alignment
                $event->sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // F3->F{$lastRow} number format
                $event->sheet->getStyle("F3:F{$lastRow}")
                    ->getNumberFormat()
                    ->setFormatCode('0');
            },
        ];
    }
}