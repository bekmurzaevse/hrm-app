<?php

namespace App\Actions\v1\Selection\Item;

use App\Dto\v1\Selection\Item\DetachCandidatesDto;
use App\Exceptions\ApiResponseException;
use App\Models\Selection;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DetachCandidatesAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param mixed $id
     * @param \App\Dto\v1\Selection\Item\DetachCandidatesDto $dto
     * @return JsonResponse
     *@throws \App\Exceptions\ApiResponseException
     */
    public function __invoke($id, DetachCandidatesDto $dto): JsonResponse
    {
        try {
            $selection = Selection::where('id', $id)
                ->where('created_by', auth()->id())
                ->firstOrFail();

            $foundCount = $selection->items()
                ->whereIn('id', $dto->items)
                ->count();

            if ($foundCount !== count($dto->items)) {
                throw new ApiResponseException('Some items not found', 404);
            }

            $selection->items()
                ->whereIn('id', $dto->items)
                ->delete();

            // Log user activity
            $title = 'Удаление кандидатов из подборок';
            $text = "Кандидаты были удалены из подборки «{$selection->title}».";
            logActivity($title, $text);

            return static::toResponse(
                message: 'Candidates detached from selection',
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Selection Not Found', 404);
        }
    }
}
