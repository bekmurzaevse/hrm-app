<?php

namespace App\Actions\v1\Type;

use App\Dto\Type\CreateDto;
use App\Models\Type;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    public function __invoke(CreateDto $dto): JsonResponse
    {
        $data = [
            'title' => $dto->title,
            'description' => $dto->description,
        ];

        Type::create($data);

        return static::toResponse(
            message: "Type created"
        );
    }

}
