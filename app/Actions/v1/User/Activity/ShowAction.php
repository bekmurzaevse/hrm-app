<?php

namespace App\Actions\v1\User\Activity;

use App\Models\UserActivity;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ShowAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $userId): JsonResponse
    {
        $activities = UserActivity::with(['user'])->where('user_id', $userId)->paginate(10);

        return static::toResponse(
            message: 'Successfully received',
            data: $activities->map( function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'text' => $item->text,
                ];
            })
        );
    }
}
