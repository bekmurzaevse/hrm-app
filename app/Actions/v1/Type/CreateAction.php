<?php

namespace App\Actions\v1\Type;

use App\Dto\Type\CreateDto;
use App\Models\Type;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Type\CreateDto $dto
     * @return JsonResponse
     */
    public function __invoke(CreateDto $dto): JsonResponse
    {
        $data = [
            'title' => $dto->title,
            'description' => $dto->description,
        ];

        $type = Type::create($data);

        logActivity(
            "Тип создан!",
            "Тип '{$type->title}' (ID: {$type->id}) был успешно создан в файле " . __FILE__
        );

        return static::toResponse(
            message: "Type created"
        );
    }

}
