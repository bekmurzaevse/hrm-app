<?php

namespace App\Actions\v1\Selection;

use App\Dto\v1\Selection\DeleteManyDto;
use App\Models\Selection;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

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
        Selection::whereIn('id', $dto->ids)->delete();

        // Log user activity
        $title = 'Удаление подборок';
        $text = "Подборки были удалены.";
        logActivity($title, $text);

        return static::toResponse(
            message: 'Selections deleted',
        );
    }
}