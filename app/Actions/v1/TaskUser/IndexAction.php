<?php 

namespace App\Actions\v1\TaskUser;

use App\Http\Resources\v1\TaskUser\TaskUserCollection;
use App\Models\TaskUser;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    public function __invoke()
    {
        $key = 'task_users:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $taskUsers = Cache::remember($key, now()->addDay(), function () {
            return TaskUser::with(['task', 'user'])->paginate(10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new TaskUserCollection($taskUsers)
        );
    }
}