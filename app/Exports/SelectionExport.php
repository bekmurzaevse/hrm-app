<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SelectionExport implements FromArray, WithHeadings, ShouldAutoSize, WithCustomStartCell, WithEvents
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Summary of array
     * @return array
     */
    public function array(): array
    {
        return $this->data['rows'];
    }

    /**
     * Summary of headings
     * @return string[]
     */
    public function headings(): array
    {
        return $this->data['headings'];
    }

    /**
     * Summary of startCell
     * @return string
     */
    public function startCell(): string
    {
        return 'B6';
    }

    /**
     * Summary of registerEvents
     * @return (callable(AfterSheet ):void)[]
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Get base data
                $baseData = $this->data['baseData'];

                // B:B wrap
                $event->sheet->getStyle('B:B')
                    ->getAlignment()
                    ->setWrapText(true);

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

                // B1->H1
                $event->sheet->mergeCells('B1:H1');
                $event->sheet->setCellValue('B1', $baseData['title']);

                // B2->H2
                $event->sheet->mergeCells('B2:H2');
                $event->sheet->setCellValue('B2', $baseData['info']);

                // B3->H3
                $event->sheet->mergeCells('B3:H3');
                $event->sheet->setCellValue('B3', $baseData['candidates']);

                // B5
                $event->sheet->setCellValue('B5', 'Список кандидатов');

                // Table format
                $startRow = 6;
                $startColumn = 'B';

                $headingsCount = count($this->data['headings']);
                $rowsCount = count($this->data['rows']);

                $startColumnIndex = Coordinate::columnIndexFromString($startColumn);
                $endColumn = Coordinate::stringFromColumnIndex($startColumnIndex + $headingsCount - 1);

                $endRow = $startRow + $rowsCount;

                $range = $startColumn . $startRow . ':' . $endColumn . $endRow;

                $event->sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }
}
