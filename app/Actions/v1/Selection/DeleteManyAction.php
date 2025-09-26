<?php

namespace App\Actions\v1\Selection;

use App\Dto\v1\Selection\DeleteManyDto;
use App\Models\Selection;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DeleteManyAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Selection\DeleteManyDto $dto
     * @return JsonResponse
     */
    public function __invoke(DeleteManyDto $dto): JsonResponse
    {
        $selections = Selection::whereIn('id', $dto->ids)
            ->where('created_by', auth()->id())
            ->get();

        if ($selections->count() !== count($dto->ids)) {
            return response()->json([
                'message' => 'Some selections not found or not accessible',
            ], 404);
        }

        DB::transaction(function () use ($selections) {
            foreach ($selections as $selection) {
                $selection->delete();
            }
        });

        // Log user activity
        $title = 'Удаление подборок';
        $text = "Подборки были удалены.";
        logActivity($title, $text);

        return static::toResponse(
            message: 'Selections deleted',
        );
    }
}