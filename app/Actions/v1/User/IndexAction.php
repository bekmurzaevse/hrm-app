<?php

namespace App\Actions\v1\User;

use App\Dto\v1\User\IndexDto;
use App\Http\Resources\v1\User\UserCollection;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\User\IndexDto $dto
     * @return JsonResponse
     */
    public function __invoke(IndexDto $dto): JsonResponse
    {
        $key = 'users:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $users = Cache::remember($key, now()->addDay(), function () use ($dto) {
            $query = User::with(['projects']);

            if ($dto->status) {
                $query->where('status', $dto->status);
            }

            if ($dto->search) {
                $query->where('first_name', 'LIKE', "%{$dto->search}%")
                    ->orWhere('last_name', 'LIKE', "%{$dto->search}%")
                    ->orWhere('patronymic', 'LIKE', "%{$dto->search}%")
                    ->orWhere('address', 'LIKE', "%{$dto->search}%")
                    ->orWhere('position', 'LIKE', "%{$dto->search}%")
                    ->orWhere('phone', 'LIKE', "%{$dto->search}%")
                    ->orWhere('email', 'LIKE', "%{$dto->search}%");
            }

            return $query->paginate($dto->perPage ?? 10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new UserCollection($users)
        );
    }
}
