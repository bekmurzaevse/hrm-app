<?php

namespace App\Exports;

use App\Models\Candidate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CandidateExport implements FromCollection, WithCustomStartCell, WithEvents, WithStyles, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Candidate::with(['user', 'district'])->get()
            ->map(function ($item, $key) {
                return [
                    '№' => $key + 1,
                    'Имя' => $item->user->first_name,
                    'Фамилия' => $item->user->last_name,
                    'Отчество' => $item->user->patronymic,
                    'Дата рождения' => $item->created_at,
                    'Гендер' => $item->gender?->value === 'male'
                            ? 'Мужской'
                            : ($item->gender?->value === 'female' ? 'Женский' : 'Не указан'),
                    'Гражданство' => $item->citizenship,
                    'Страна проживания' => $item->country_residence,
                    'Район' => $item->district->title,
                    'Адрес' => $item->address,
                    'Семейная информация' => $item->family_info,
                    'Семейный статус' => match ($item->family_status?->value) {
                        'married'   => 'Женат / Замужем',
                        'unmarried' => 'Не женат / Не замужем',
                        'divorced'  => 'Разведён(а)',
                        default     => 'Не указан',
                    },
                    'Статус' => match ($item->status?->value) {
                        'employed'  => 'Трудоустроен',
                        'in_search' => 'В поиске работы',
                        default     => 'Не указан',
                    },
                    'Место работы' => $item->workplace,
                    'Позиция' => $item->position,
                    'Желаемая зарплата' => $item->desired_salary,
                    'Источник' => $item->source,
                    'Создано' => $item->user->first_name . ' ' . $item->user->last_name,
                    'Опыт' => (function ($months) {
                        $months = (int) $months;
                        $years = intdiv($months, 12);
                        $remainMonths = $months % 12;

                        $result = [];
                        if ($years > 0) {
                            $result[] = $years . ' ' . ($years === 1 ? 'год' : ($years < 5 ? 'года' : 'лет'));
                        }
                        if ($remainMonths > 0) {
                            $result[] = $remainMonths . ' ' . ($remainMonths === 1 ? 'месяц' : ($remainMonths < 5 ? 'месяца' : 'месяцев'));
                        }

                        return $result ? implode(' ', $result) : 'Нет опыта';
                    })($item->experience),
                    'Краткое резюме' => $item->short_summary,
                    'Достижения' => $item->achievments,
                    'Комментарий' => $item->comment,
                    'Описание' => $item->description,
                ];
            });
    }

    public function headings(): array
    {
        return [
            '№',
            'Имя',
            'Фамилия',
            'Отчество',
            'Дата рождения',
            'Гендер',
            'Гражданство',
            'Страна проживания',
            'Район',
            'Адрес',
            'Семейная информация',
            'Семейная статус',
            'Статус',
            'Место работы',
            'Позиция',
            'Желаемая зарплата',
            'Источник',
            'Создано',
            'Опыт',
            'Краткое резюме',
            'Достижения',
            'Комментарий',
            'Описание',
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
     * Summary of styles
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @return array[]
     */
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

    /**
     * Summary of registerEvents
     * @return array<(callable(AfterSheet ):void)|(callable(BeforeSheet ):void)>
     */
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $sheet = $event->sheet;

                $sheet->mergeCells('C1:X1');
                $sheet->setCellValue('C1', 'Кандидаты');

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

                $sheet->getStyle("B3:B{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                foreach (range('B', $lastColumn) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                $sheet->getStyle("F3:{$lastColumn}{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
