<?php

namespace App\Actions\v1\User\Activity;

use App\Models\UserActivity;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class IndexAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $activities = UserActivity::with(['user'])->paginate(10);

        return static::toResponse(
            message: 'Successfully received',
            data: $activities->map( function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'user' => $item->user->first_name . ' ' . $item->user->last_name,
                    'text' => $item->text,
                ];
            })
        );
    }
}
