<?php

namespace App\Actions\v1\Type;

use App\Dto\v1\Type\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Models\Type;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @param \App\Dto\v1\Type\UpdateDto $dto
     * @return JsonResponse
     *@throws \App\Exceptions\ApiResponseException
     */
    public function __invoke(int $id, UpdateDto $dto): JsonResponse
    {
        try {
            $type = Type::findOrFail($id);
            $oldTitle = $type->title;

            $type->update([
                'title' => $dto->title,
                'description' => $dto->description,
            ]);

            logActivity(
                "Тип обновлён!",
                "Тип '{$oldTitle}' был изменён на '{$dto->title}' (ID: {$id}) в файле " . __FILE__
            );

            return static::toResponse(
                message: "$id - id li Type jan'alandi",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Type Not Found', 404);
        }
    }
}
