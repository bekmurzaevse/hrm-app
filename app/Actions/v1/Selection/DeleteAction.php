<?php

namespace App\Actions\v1\Selection;

use App\Exceptions\ApiResponseException;
use App\Models\Selection;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Selection\CreateDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $selection = Selection::findOrFail($id);

            if ($selection->created_by !== auth()->id()) {
                throw new ApiResponseException('You are not allowed to access this selection', 403);
            }

            $selection->delete();

            // Log user activity
            $title = 'Удаление подборки';
            $text = "Подборка «{$selection->title}» была удалена.";
            logActivity($title, $text);

            return static::toResponse(
                message: 'Selection deleted',
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Selection Not Found', 404);
        }
    }
}