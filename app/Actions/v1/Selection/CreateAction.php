<?php

namespace App\Actions\v1\Selection;

use App\Dto\v1\Selection\CreateDto;
use App\Models\Selection;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Selection\CreateDto $dto
     * @return JsonResponse
     */
    public function __invoke(CreateDto $dto): JsonResponse
    {
        $selection = Selection::create([
            'title' => $dto->title,
            'created_by' => auth()->id()
        ]);

        // Log user activity
        $title = 'Создал подборку';
        $text = "Подборка «{$selection->title}» была создана.";
        logActivity($title, $text);

        return static::toResponse(
            message: 'Selection created',
        );
    }
}