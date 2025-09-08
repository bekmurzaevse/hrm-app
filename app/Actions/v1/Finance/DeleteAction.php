<?php

namespace App\Actions\v1\Finance;

use App\Exceptions\ApiResponseException;
use App\Models\Finance;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $finance = Finance::findOrFail($id);

            logActivity(
                title: 'Финансовая запись удалена',
                text: "Финансовая запись #{$finance->type->value} была удалена. Сумма: {$finance->amount}, Проект: {$finance->project_id}"
            );

            $finance->delete();

            return static::toResponse(
                message: "$id - id li Finance o'shirildi",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Finance Not Found', 404);
        }
    }
}
