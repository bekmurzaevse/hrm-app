<?php

namespace App\Actions\v1\Selection\SelectionItem;

use App\Dto\v1\Selection\SelectionItem\AttachCandidatesDto;
use App\Exceptions\ApiResponseException;
use App\Models\SelectionItem;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AttachCandidatesAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Selection\SelectionItem\AttachCandidatesDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(AttachCandidatesDto $dto): JsonResponse
    {
        $selections = $dto->selections;
        $candidates = $dto->candidates;

        // Get all combinations from request
        $data = [];
        foreach ($selections as $selectionId) {
            foreach ($candidates as $candidateId) {
                $data[] = [
                    'selection_id' => $selectionId,
                    'candidate_id' => $candidateId,
                ];
            }
        }

        // Get existing from DB
        $existing = SelectionItem::whereIn('selection_id', $selections)
            ->whereIn('candidate_id', $candidates)
            ->get(['selection_id', 'candidate_id'])
            ->map(fn($item) => $item->selection_id . '-' . $item->candidate_id)
            ->toArray();

        // Convert to array
        $existingLookup = array_flip($existing);

        // Check for duplicates
        $new = [];
        $duplicates = [];

        foreach ($data as $row) {
            $key = $row['selection_id'] . '-' . $row['candidate_id'];
            if (isset($existingLookup[$key])) {
                $duplicates[$row['selection_id']][] = $row['candidate_id'];
            } else {
                $new[] = $row;
            }
        }

        // Check for empty new array and throw exception
        if (empty($new)) {
            throw new ApiResponseException('All candidates already attached', 422);
        }

        // Insert
        DB::transaction(function () use ($new) {
            SelectionItem::insert($new);
        });

        // Count duplicates
        $totalDuplicates = 0;
        foreach ($duplicates as $selectionId => $candidateIds) {
            $totalDuplicates += count($candidateIds);
        }

        // Format duplicates
        $formattedDuplicates = [];
        foreach ($duplicates as $selectionId => $candidateIds) {
            $formattedDuplicates[] = [
                'selection_id' => (int) $selectionId,
                'candidate_ids' => $candidateIds,
            ];
        }

        // Log user activity
        $title = 'Добавление кандидатов к подборкам';
        $text = "Кандидаты были добавлены к подборкам.";
        logActivity($title, $text);

        // Return
        return static::toResponse(
            message: 'Candidates attached to selections',
            data: [
                'attached_count' => count($new),
                'duplicate_count' => $totalDuplicates,
                'duplicates' => $formattedDuplicates
            ]
        );
    }
}
