<?php

namespace App\Actions\v1\Selection;

use App\Exceptions\ApiResponseException;
use App\Exports\SelectionExport;
use App\Models\Selection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportShowAction
{
    /**
     * Summary of __invoke
     * @param int $selectionId
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function __invoke(int $selectionId): BinaryFileResponse
    {
        try {
            // Get selection data
            $selection = Selection::with([
                'items.candidate',
                'items.statusValues',
                'statuses',
            ])->where('created_by', auth()->id())
                ->findOrFail($selectionId);

            $statuses = collect([
                [
                    'id' => null,
                    'title' => 'Соискатель',
                    'order' => 0,
                ],
            ])->merge(
                    $selection->statuses->map(function ($status) {
                        return [
                            'id' => $status->id,
                            'title' => $status->title,
                            'order' => $status->order,
                        ];
                    })
                )->sortBy('order')->values();

            $candidates = $selection->items->count();
            $candidates_count = $selection->items->whereNotNull('candidate_id')->count();
            $external = $selection->items->whereNotNull('external_name')->count();

            $baseData = [
                'title' => "Подборка: " . $selection->title,
                "info" => "Создано: " . $selection->created_at?->format('Y-m-d') . "     " . "Автор: " . $selection->createdBy?->shortFio,
                "candidates" => "Кандидаты: " . $candidates . " (из базы: " . $candidates_count . ", вручную: " . $external . ")"
            ];

            // Export data
            $data = [];
            $rows = [];

            // Selection table data
            foreach ($selection->items as $item) {

                if ($item->candidate_id === null) {
                    $candidate = $item->external_name . "\r\n" . "Ручной ввод";
                } else {
                    $candidate = $item->candidate->last_name . ' ' .
                        $item->candidate->first_name . ' ' .
                        $item->candidate->patronymic . "\r\n" . "Из базы";
                }

                $row = [
                    'Соискатель' => $candidate
                ];

                foreach ($statuses as $status) {
                    if ($status['id'] === null) {
                        continue;
                    }
                    $statusValue = $item->statusValues
                        ->where('selection_status_id', $status['id'])
                        ->first();

                    $row[$status['title']] = $statusValue->value ?? "";
                }

                $rows[] = $row;
            }

            // Prepare data
            $data['rows'] = $rows;
            $data['headings'] = $statuses->pluck('title')->toArray();
            $data['baseData'] = $baseData;

            $filename = 'Моя_подборка_' . Str::slug($selection->title, '_') . '_' . now()->format('Y_m_d_H_i_s') . '.xlsx';

            return Excel::download(new SelectionExport($data), $filename);
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Selection not found', 404);
        }
    }
}