<?php

namespace App\Exports;

use App\Models\Selection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SelectionsExport implements FromCollection, ShouldAutoSize, WithCustomStartCell, WithEvents, WithHeadings, WithMapping
{
    protected int $rowIndex = 0;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Selection::withCount('items')
            ->where('created_by', auth()->id())
            ->get();
    }

    /**
     * Summary of headings
     * @return string[]
     */
    public function headings(): array
    {
        return ['№', 'Заголовок', 'Создано', 'Изменено', 'Кандидаты'];
    }

    /**
     * Summary of map
     * @param mixed $selection
     * @return array<int|mixed>
     */
    public function map($selection): array
    {
        $this->rowIndex++;

        return [
            $this->rowIndex,
            $selection->title,
            $selection->created_at->format('Y-m-d'),
            $selection->updated_at->format('Y-m-d'),
            (string) $selection->items_count,
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

    /**
     * Summary of registerEvents
     * @return (callable(AfterSheet ):void)[]
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // B1->E1 merge and title
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

                // B2:E2 bold
                $event->sheet->getStyle('B2:F2')->getFont()->setBold(true);

                // Get last row count
                $lastRow = count($this->collection()) + 2;

                // B2->E{$lastRow} draw border
                $range = "B2:F{$lastRow}";
                $event->sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(
                    Border::BORDER_THIN
                );

                // B2->F{$lastRow} set horizontal center
                $range = "B2:F{$lastRow}";
                $event->sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // C3->C{$lastRow} set horizontal left for FIO
                $range = "C3:C{$lastRow}";
                $event->sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            },
        ];
    }
}