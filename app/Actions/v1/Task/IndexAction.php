<?php

namespace App\Actions\v1\Task;

use App\Dto\v1\Task\TaskCollection;
use App\Models\Task;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $key = 'tasks:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $tasks = Cache::remember($key, now()->addDay(), function () {
            return Task::with(['creator'])->paginate(10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new TaskCollection($tasks)
        );
    }
}