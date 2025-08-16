<?php

namespace App\Actions\v1\Type;

use App\Dto\Type\UpdateDto;
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
     * @param \App\Dto\Type\UpdateDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id, UpdateDto $dto): JsonResponse
    {
        try {
            $type = Type::findOrFail($id);
            $type->update([
                'title' => $dto->title,
                'description' => $dto->description,
            ]);

            return static::toResponse(
                message: "$id - id li Type jan'alandi",
                // data: new CandidateResource($candidate)
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Type Not Found', 404);
        }
    }
}
